# 🍔 HFT Food Store - Website Đặt Đồ Ăn Trực Tuyến

> **Dự án Thực tập:** Xây dựng hệ thống Website đặt đồ ăn trực tuyến hỗ trợ vận hành toàn diện cho cửa hàng HFT.

Hệ thống cung cấp trải nghiệm đặt món ăn nhanh chóng cho khách hàng, đồng thời tích hợp các công cụ quản lý tập trung cho Quản trị viên và phân hệ xử lý giao vận dành riêng cho Nhân viên giao hàng (Shipper).

---

## 🚀 Công nghệ sử dụng
* **Môi trường chạy:** XAMPP (Localhost)
* **Backend:** PHP
* **Database:** MySQL / SQL Server
* **Frontend:** HTML, CSS, JavaScript
* **Thư viện tích hợp:** 
  * `PHPMailer`: Hỗ trợ gửi email tự động (xác thực, quên mật khẩu).
  * `tfpdf`: Xuất file định dạng PDF để in hóa đơn giao hàng.

---

## ✨ Phân hệ & Tính năng nổi bật

### 👤 1. Khách hàng (Customer)
* **Tài khoản:** Đăng ký, đăng nhập, cập nhật hồ sơ và lấy lại mật khẩu qua Email.
* **Mua sắm:** Tìm kiếm món ăn theo tên, lọc theo danh mục, mức giá và độ phổ biến.
* **Giỏ hàng & Đặt hàng:** Thêm/sửa/xóa món trong giỏ, chọn phương thức thanh toán (COD hoặc Chuyển khoản).
* **Quản lý đơn hàng:** Theo dõi trạng thái đơn, yêu cầu hủy đơn (khi chờ xác nhận), gửi yêu cầu hoàn tiền và đánh giá (rating) món ăn sau khi nhận.

### 🛡️ 2. Quản lý (Admin/Manager)
* **Dashboard Thống kê:** Theo dõi số lượng đơn hàng, doanh thu theo ngày/tháng/năm và top các món bán chạy nhất.
* **Quản lý Thực đơn (CRUD):** Thêm, sửa, xóa danh mục và món ăn, cập nhật trạng thái (Đang bán/Hết hàng).
* **Xử lý Đơn hàng:** Duyệt đơn, đối soát thanh toán, phân công đơn cho Shipper và in hóa đơn (PDF).
* **Quản lý Hệ thống:** Quản lý tài khoản người dùng, khóa/mở tài khoản vi phạm, phân quyền (Admin, Customer, Shipper) và kiểm duyệt đánh giá.

### 🛵 3. Nhân viên Giao hàng (Shipper)
* **Tiếp nhận đơn:** Xem danh sách các đơn hàng được Admin phân công kèm thông tin liên lạc và địa chỉ của khách.
* **Cập nhật giao vận:** Thay đổi trạng thái đơn hàng theo thời gian thực ("Giao thành công").

---

## 🛠️ Hướng dẫn cài đặt (Local Setup)

Để chạy dự án này trên máy tính cá nhân của bạn, vui lòng thực hiện các bước sau:

**1. Yêu cầu hệ thống**
* Cài đặt phần mềm **XAMPP** (đã bao gồm Apache và MySQL).

**2. Cài đặt dự án**
* Clone repository này về máy tính:
  `git clone https://github.com/huytruong204/CuaHangHFT.git`
* Copy toàn bộ thư mục mã nguồn dự án bỏ vào thư mục `htdocs` của XAMPP (Đường dẫn thường là: `C:\xampp\htdocs\`).

**3. Thiết lập Cơ sở dữ liệu**
* Mở XAMPP Control Panel, khởi động **Apache** và **MySQL**.
* Truy cập vào phpMyAdmin qua đường dẫn: `http://localhost/phpmyadmin/`
* Tạo một cơ sở dữ liệu mới 
* Import file cơ sở dữ liệu (`.sql`) đính kèm trong source code vào database vừa tạo.

**4. Cấu hình kết nối**
* Mở file cấu hình kết nối database trong source code
* Thay đổi các thông số (Tên database, username, password) sao cho khớp với cấu hình MySQL trên máy của bạn.

**5. Khởi chạy**
* Mở trình duyệt web và truy cập: `http://localhost/ten_thu_muc_du_an/`

---

## 👤 Tác giả
* **Trương Công Huy**
