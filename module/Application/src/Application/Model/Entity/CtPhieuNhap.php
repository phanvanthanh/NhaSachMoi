<?php
namespace Application\Model\Entity;

class CtPhieuNhap
{
    
    protected $id_ct_phieu_nhap;
    protected $id_phieu_nhap;
    protected $id_san_pham;
    protected $so_luong;
    protected $gia_nhap;

    

    public function exchangeArray($data)
    {
        $this->id_ct_phieu_nhap = (isset($data['id_ct_phieu_nhap'])) ? $data['id_ct_phieu_nhap'] : null;
        $this->id_san_pham = (isset($data['id_san_pham'])) ? $data['id_san_pham'] : null;
        $this->id_phieu_nhap = (isset($data['id_phieu_nhap'])) ? $data['id_phieu_nhap'] : null;
        $this->so_luong = (isset($data['so_luong'])) ? $data['so_luong'] : null;
        $this->gia_nhap = (isset($data['gia_nhap'])) ? $data['gia_nhap'] : null;
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdCtPhieuNhap($id_ct_phieu_nhap)
    {
        $this->id_ct_phieu_nhap=$id_ct_phieu_nhap;
    }

    public function getIdCtPhieuNhap()
    {
        return $this->id_ct_phieu_nhap;
    }

    public function setIdSanPham($id_san_pham)
    {
        $this->id_san_pham=$id_san_pham;
    }

    public function getIdSanPham()
    {
        return $this->id_san_pham;
    }

    public function setIdPhieuNhap($id_phieu_nhap)
    {
        $this->id_phieu_nhap=$id_phieu_nhap;
    }

    public function getIdPhieuNhap()
    {
        return $this->id_phieu_nhap;
    }

    public function setSoLuong($so_luong)
    {
        $this->so_luong=$so_luong;
    }

    public function getSoLuong()
    {
        return $this->so_luong;
    }


    public function setGiaNhap($gia_nhap)
    {
        $this->gia_nhap=$gia_nhap;
    }

    public function getGiaNhap()
    {
        return $this->gia_nhap;
    }
    
}
