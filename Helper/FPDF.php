<?php
/* Simple, robust minimal FPDF replacement tailored for this project.
   Supports: AddPage(), SetFont(), Cell(), Ln(), Output().
   This is not a full FPDF implementation but is sufficient for basic text invoices.
*/

if (!class_exists('FPDF')) {
    class FPDF {
        protected $buffer = '';
        protected $page_contents = '';
        protected $pages = [];
        protected $fontSize = 12;
        protected $y = 800; // start from top-ish in PDF coordinates

        public function __construct($orientation='P', $unit='mm', $size='A4') {
            // no-op for minimal implementation
        }

        public function AddPage() {
            if (!empty($this->page_contents)) {
                $this->pages[] = $this->page_contents;
            }
            $this->page_contents = '';
            $this->y = 800;
        }

        public function SetFont($family, $style='', $size=12) {
            $this->fontSize = $size;
        }

        public function SetFontSize($size) { $this->fontSize = $size; }

        public function Ln($h = null) {
            if ($h === null) $h = max(6, $this->fontSize);
            $this->y -= $h;
        }

        protected function escape($s) {
            $s = str_replace('\\', '\\\\', $s);
            $s = str_replace('(', '\\(', $s);
            $s = str_replace(')', '\\)', $s);
            $s = str_replace("\r", '', $s);
            return $s;
        }

        public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
            $text = (string)$txt;
            $this->writeTextLine($text);
        }

        protected function writeTextLine($text) {
            $escaped = $this->escape($text);
            // Write a simple text object using Helvetica at fixed position
            $this->page_contents .= sprintf("BT /F1 %d Tf 50 %d Td (%s) Tj ET\n", max(6, (int)$this->fontSize), (int)$this->y, $escaped);
            $this->y -= max(8, $this->fontSize + 2);
        }

        protected function assemblePdf() {
            // flush last page
            if (!empty($this->page_contents)) $this->pages[] = $this->page_contents;

            $pageContent = isset($this->pages[0]) ? $this->pages[0] : '';

            $buffer = "%PDF-1.3\n%\xE2\xE3\xCF\xD3\n"; // binary comment
            $offsets = [];

            // 1 Catalog
            $offsets[1] = strlen($buffer);
            $buffer .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";

            // 2 Pages
            $offsets[2] = strlen($buffer);
            $buffer .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";

            // 3 Page
            $offsets[3] = strlen($buffer);
            $buffer .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n";

            // 4 Font
            $offsets[4] = strlen($buffer);
            $buffer .= "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

            // 5 Content stream
            $stream = $pageContent;
            $offsets[5] = strlen($buffer);
            $buffer .= "5 0 obj\n<< /Length " . strlen($stream) . " >>\nstream\n" . $stream . "\nendstream\nendobj\n";

            // xref
            $xrefPos = strlen($buffer);
            $buffer .= "xref\n0 6\n0000000000 65535 f \n";
            for ($i = 1; $i <= 5; $i++) {
                $buffer .= sprintf("%010d 00000 n \n", $offsets[$i]);
            }

            $buffer .= "trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n" . $xrefPos . "\n%%EOF";

            return $buffer;
        }

        public function Output($dest='I', $name='doc.pdf') {
            $pdf = $this->assemblePdf();

            if ($dest === 'I' || $dest === 'D') {
                // Clean any prior output buffers to avoid corrupting PDF
                if (ob_get_level()) {
                    while (ob_get_level() > 0) ob_end_clean();
                }

                header('Content-Type: application/pdf');
                $disposition = ($dest === 'D') ? 'attachment' : 'inline';
                header('Content-Disposition: ' . $disposition . '; filename="' . basename($name) . '"');
                header('Content-Length: ' . strlen($pdf));
                echo $pdf;
                return;
            }
            file_put_contents($name, $pdf);
        }
    }
}
