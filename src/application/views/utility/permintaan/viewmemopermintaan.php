<?php

class Memo extends FPDF
{
    private $data = array();

    public function setData($data)
    {
        $this->data = $data;
    }

    function Header()
    {
        $this->setFillColor(255, 255, 255);
        $this->setFont('Times', 'B', 10);

        $this->SetXY(5, 5);
        $this->Cell(25, 14, '', '', 0, 'C', true);
        $this->Image("assets/img/PSG_logo_2022.png", 10, 10, 20, 0, 'PNG');
        $this->setFont('Times', 'B', 12);
        $this->Cell(116, 14, 'PT PULAU SAMBU', '', 1, 'C', true);
        $this->setFont('Times', 'B', 14);
        $this->Cell(56);
        $this->Cell(45, 7, 'INTERNAL MEMO', 'B', 0, 'L', true);
        $this->Ln();
        $this->setFont('Times', '', 9);
        $this->Cell(56);
        $this->Cell(45, 7, $this->data->Doc, '', 0, 'C', true);
        $this->Ln(15);
        $this->setFont('Times', '', 9);
        $this->Cell(30);
        $this->Cell(30, 6, 'Kepada', '', 0, 'L', true);
        $this->Cell(5, 6, ':', '', 0, 'C', true);
        $this->Cell(45, 6, 'MGT', '', 1, 'L', true);
        $this->Cell(30);
        $this->Cell(30, 6, 'CC', '', 0, 'L', true);
        $this->Cell(5, 6, ':', '', 0, 'C', true);
        $this->Cell(45, 6, 'HRD', '', 1, 'L', true);
        $this->Cell(30);
        $this->Cell(30, 6, 'Dari', '', 0, 'L', true);
        $this->Cell(5, 6, ':', '', 0, 'C', true);
        $this->Cell(45, 6, 'Dept. ' . $this->data->DeptAbbr, '', 1, 'L', true);
        $this->Cell(30);
        $this->Cell(30, 6, 'Hari / Tanggal', '', 0, 'L', true);
        $this->Cell(5, 6, ':', '', 0, 'C', true);
        if (date('D', strtotime($this->data->CreatedDate)) == 'Sun') {
            $this->Cell(45, 6, 'Minggu / ' . date('d-m-Y', strtotime($this->data->CreatedDate)), '', 1, 'L', true);
        } elseif (date('D', strtotime($this->data->CreatedDate)) == 'Mon') {
            $this->Cell(45, 6, 'Senin / ' . date('d-m-Y', strtotime($this->data->CreatedDate)), '', 1, 'L', true);
        } elseif (date('D', strtotime($this->data->CreatedDate)) == 'Tue') {
            $this->Cell(45, 6, 'Selasa / ' . date('d-m-Y', strtotime($this->data->CreatedDate)), '', 1, 'L', true);
        } elseif (date('D', strtotime($this->data->CreatedDate)) == 'Wed') {
            $this->Cell(45, 6, 'Rabu / ' . date('d-m-Y', strtotime($this->data->CreatedDate)), '', 1, 'L', true);
        } elseif (date('D', strtotime($this->data->CreatedDate)) == 'Thu') {
            $this->Cell(45, 6, 'Kamis / ' . date('d-m-Y', strtotime($this->data->CreatedDate)), '', 1, 'L', true);
        } elseif (date('D', strtotime($this->data->CreatedDate)) == 'Fri') {
            $this->Cell(45, 6, 'Jumat / ' . date('d-m-Y', strtotime($this->data->CreatedDate)), '', 1, 'L', true);
        } else {
            $this->Cell(45, 6, 'Sabtu / ' . date('d-m-Y', strtotime($this->data->CreatedDate)), '', 1, 'L', true);
        }
        $this->Cell(30);
        $this->Cell(30, 6, 'Perihal', '', 0, 'L', true);
        $this->Cell(5, 6, ':', '', 0, 'C', true);
        if ($this->data->IsKry == 1) {
            $this->Cell(45, 6, 'Permohonan Penambahan Jumlah Karyawan Ideal Dept', '', 1, 'L', true);
        } else {
            $this->Cell(45, 6, 'Permohonan Penambahan Jumlah TK Ideal Dept', '', 1, 'L', true);
        }
    }

    function Content($r)
    {

        $this->setFont('Times', '', 10);
        $this->setFillColor(255, 255, 255);

        $this->Ln(10);
        $this->SetX(10);
        $this->Cell(156, 6, 'Dengan hormat,', '', 1, 'L', TRUE);
        if ($this->data->IsKry == 1) {
            $this->Cell(156, 6, 'Melalui internal memo ini kami mohon untuk penambahan Karyawan Ideal diprogram rekrutmen', '', 1, 'L', true);
        } else {
            $this->Cell(156, 6, 'Melalui internal memo ini kami mohon untuk penambahan TK Ideal diprogram rekrutmen', '', 1, 'L', true);
        }

        $this->Ln(5);
        $this->SetX(10);
        $this->Cell(50, 7, 'Jumlah ideal sekarang', '', 0, 'L', TRUE);
        $this->Cell(2, 7, ':', 0, 'L', true);
        if ($this->data->IsKry == 1) {
            $this->Cell(105, 7, $this->data->IKry, '', 1, 'L', true);
        } else {
            $this->Cell(105, 7, $this->data->IBor, '', 1, 'L', true);
        }
        $this->Cell(50, 7, 'Jumlah ideal tambahan', '', 0, 'L', TRUE);
        $this->Cell(2, 7, ':', 0, 'L', true);
        if ($this->data->IsKry == 1) {
            $this->Cell(105, 7, ($this->data->Jumlah - $this->data->IKry), '', 1, 'L', true);
        } else {
            $this->Cell(105, 7, ($this->data->Jumlah - $this->data->IBor), '', 1, 'L', true);
        }
        $this->Cell(50, 7, 'Total', '', 0, 'L', TRUE);
        $this->Cell(2, 7, ':', 0, 'L', true);
        if ($this->data->IsKry == 1) {
            $this->Cell(105, 7, ($this->data->Jumlah), '', 1, 'L', true);
        } else {
            $this->Cell(105, 7, ($this->data->Jumlah), '', 1, 'L', true);
        }
        $this->Ln(5);
        if ($this->data->IsKry == 1) {
            $this->Cell(156, 6, 'Alasan penambahan Karyawan Ideal sebagai berikut :', '', 1, 'L', true);
        } else {
            $this->Cell(156, 6, 'Alasan penambahan TK Ideal sebagai berikut :', '', 1, 'L', true);
        }
        $this->Cell(2, 7, '', 0, 'L', true);
        $this->MultiCell(105, 7, ($this->data->Alasan), '', 1, 'L', true);

        $this->Ln(5);
        if ($this->data->IsKry == 1) {
            $this->Cell(156, 6, 'Alasan penambahan/pengurangan Karyawan Ideal oleh Management sebagai berikut :', '', 1, 'L', true);
        } else {
            $this->Cell(156, 6, 'Alasan penambahan/pengurangan TK Ideal oleh Management sebagai berikut :', '', 1, 'L', true);
        }
        $this->Cell(2, 7, '', 0, 'L', true);
        $this->MultiCell(105, 7, ($this->data->Keterangan), '', 1, 'L', true);

        $this->Ln(7);
        $this->Cell(156, 6, 'Demikian kami sampaikan, atas kerjasamanya kami ucapkan terimakasih.', '', 1, 'L', true);

        $this->Ln(7);
        $this->Cell(32, 6, 'Dibuat Oleh,', '', 0, 'L', true);
        $this->Cell(32, 6, '', '', 0, 'L', true);
        $this->Cell(32, 6, 'Diketahui Oleh,', '', 0, 'L', true);
        $this->Cell(32, 6, '', '', 0, 'L', true);
        $this->Cell(32, 6, 'Disetujui Oleh,', '', 1, 'L', true);
        $this->Ln(17);
        if ($this->data->Approved1Sts == 1) {
            $this->Image("assets/tanda_tangan/" . strtoupper($this->data->Approved1By) . ".png", 15, 180, 15, 0, 'PNG');
        }
        if ($this->data->Approved2Sts == 1) {
            $this->Image("assets/tanda_tangan/" . strtoupper($this->data->Approved2By) . ".png", 75, 178, 25, 0, 'PNG');
        }

        if ($this->data->Approved3Sts == 1) {
            $this->Image("assets/tanda_tangan/" . strtoupper($this->data->Approved3By) . ".png", 138, 178, 25, 0, 'PNG');
        }
        $this->Cell(34, 6, strtoupper($this->data->Approved1By), '', 0, 'L', true);
        $this->Cell(30, 6, '', '', 0, 'L', true);
        $this->Cell(32, 6, strtoupper($this->data->Approved2By), '', 0, 'L', true);
        $this->Cell(32, 6, '', '', 0, 'L', true);
        $this->Cell(32, 6, strtoupper($this->data->Approved3By), '', 1, 'L', true);
        $this->Cell(32, 6, 'Pimpinan Dept', 'T', 0, 'L', true);
        $this->Cell(32, 6, '', '', 0, 'L', true);
        $this->Cell(32, 6, 'Mgr. Divisi', 'T', 0, 'L', true);
        $this->Cell(32, 6, '', '', 0, 'L', true);
        $this->Cell(32, 6, 'Management', 'T', 1, 'L', true);


        $this->Line(5, 75, 171, 75);
        $this->Line(5, 5, 5, 245);
        $this->Line(5, 5, 171, 5);
        $this->Line(5, 245, 171, 245);
        $this->Line(171, 5, 171, 245);
    }
}

$pdf = new Memo('P', 'mm', array(176, 250));
$pdf->setData($_dataHeader);
$pdf->AddPage();
$pdf->SetAutoPageBreak(FALSE);
$pdf->Content($_dataContent);
$pdf->Output();
