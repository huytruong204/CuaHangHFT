<?php
include_once __DIR__ . '/../Model/UserModel.php';
include_once __DIR__ . '/../Helper/SessionManager.php';

// PHPMailer
require_once __DIR__ . '/../libs/src/Exception.php';
require_once __DIR__ . '/../libs/src/PHPMailer.php';
require_once __DIR__ . '/../libs/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Show form and handle sending reset email
    public function forgotPassword()
    {
        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Vui lòng nhập email hợp lệ.';
            } else {
                if (!$this->userModel->checkEmailExists($email)) {
                    $error = 'Không tìm thấy tài khoản với email này.';
                } else {
                    // generate token
                    $token = bin2hex(random_bytes(16));
                    $ok = $this->userModel->saveToken($email, $token, 30);
                    if (!$ok) {
                        $error = 'Không thể tạo token. Vui lòng thử lại sau.';
                    } else {
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                        $host = $_SERVER['HTTP_HOST'];
                        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\\/');
                        $link = $protocol . '://' . $host . $base . '/index.php?page=Auth&action=resetPassword&token=' . $token;

                        $subject = 'Yêu cầu đặt lại mật khẩu';
                        $message = "Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.\n\n";
                        $message .= "Nhấn vào liên kết sau để đặt lại mật khẩu (hết hạn trong 30 phút):\n" . $link . "\n\n";
                        $message .= "Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.";

                        // Send via PHPMailer (Mailtrap)
                        try {
                            $this->sendEmail($email, $token, $link);
                            $success = 'Đã gửi liên kết đặt lại mật khẩu đến email của bạn.';
                        } catch (Exception $e) {
                            error_log('Mail error: ' . $e->getMessage());
                            // Do not reveal failure to user
                            $success = 'Yêu cầu được tạo. Vui lòng kiểm tra email (nếu không thấy, kiểm tra thư mục spam).';
                        }
                    }
                }
            }
        }

        return require_once "./View/Auth/forgot_password.php";
    }

    // Show form to reset or handle reset
    public function resetPassword()
    {
        $token = $_GET['token'] ?? ($_POST['token'] ?? '');
        $error = '';
        $success = '';

        if (empty($token)) {
            $error = 'Token không tồn tại.';
            return require_once "./View/Auth/reset_password.php";
        }

        $row = $this->userModel->verifyToken($token);
        if (!$row) {
            $error = 'Token không hợp lệ hoặc đã hết hạn.';
            return require_once "./View/Auth/reset_password.php";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            if (empty($password) || strlen($password) < 6) {
                $error = 'Mật khẩu phải tối thiểu 6 ký tự.';
            } elseif ($password !== $confirm) {
                $error = 'Mật khẩu và xác nhận mật khẩu không khớp.';
            } else {
                $email = $row['email'];
                $ok = $this->userModel->updatePassword($email, $password);
                if ($ok) {
                    SessionManager::flash('success', 'Mật khẩu đã được thay đổi. Vui lòng đăng nhập.');
                    header('Location: index.php?page=SignIn');
                    exit;
                } else {
                    $error = 'Không thể cập nhật mật khẩu. Vui lòng thử lại.';
                }
            }
        }

        return require_once "./View/Auth/reset_password.php";
    }

    // Send reset email using PHPMailer and Mailtrap sandbox
    private function sendEmail($toEmail, $token, $link)
    {
        $mail = new PHPMailer(true);

        // Mailtrap SMTP settings
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '1d261532e7d752';
        // Mailtrap SMTP password (inserted)
        $mail->Password = 'a37283986fba50';

        // Recommended secure settings
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAutoTLS = true;
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Debugging: set to 2 for verbose, 0 for off. We'll capture info on failure.
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = function ($str, $level) {
            error_log("PHPMailer debug level $level: $str");
        };

        $mail->CharSet = 'UTF-8';
        $mail->setFrom('no-reply@' . $_SERVER['HTTP_HOST'], 'HFT Demo');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Yêu cầu đặt lại mật khẩu';
        $mail->Body = "<p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>" .
            "<p>Nhấp vào liên kết bên dưới để đặt lại mật khẩu (hết hạn trong 30 phút):</p>" .
            "<p><a href='" . htmlspecialchars($link) . "'>" . htmlspecialchars($link) . "</a></p>" .
            "<p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>";

        try {
            if (!$mail->send()) {
                // PHPMailer may not throw exception but return false
                $err = $mail->ErrorInfo;
                error_log('PHPMailer send() returned false: ' . $err);
                throw new Exception('Mailer Error: ' . $err);
            }
            return true;
        } catch (Exception $e) {
            // Log both PHPMailer ErrorInfo and exception message for diagnosis
            error_log('PHPMailer Exception: ' . $e->getMessage());
            if (!empty($mail->ErrorInfo)) error_log('PHPMailer ErrorInfo: ' . $mail->ErrorInfo);
            throw $e;
        }
    }
}
