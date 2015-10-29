<?php
namespace Application\Model\Entity;

class CtHoaDon
{
    
    protected $id_ct_hoa_don;
    protected $id_hoa_don;
    protected $id_san_pham;
    protected $gia;
    protected $so_luong;
    protected $gia_nhap;
    protected $state;
    protected $so_luong_tra;

    

    public function exchangeArray($data)
    {
        $this->id_ct_hoa_don = (isset($data['id_ct_hoa_don'])) ? $data['id_ct_hoa_don'] : null;
        $this->id_san_pham = (isset($data['id_san_pham'])) ? $data['id_san_pham'] : null;
        $this->id_hoa_don = (isset($data['id_hoa_don'])) ? $data['id_hoa_don'] : null;
        $this->gia = (isset($data['gia'])) ? $data['gia'] : null;
        $this->so_luong = (isset($data['so_luong'])) ? $data['so_luong'] : null;
        $this->gia_nhap = (isset($data['gia_nhap'])) ? $data['gia_nhap'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : 0;
        $this->so_luong_tra = (isset($data['so_luong_tra'])) ? $data['so_luong_tra'] : 0;
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdCtHoaDon($id_ct_hoa_don)
    {
        $this->id_ct_hoa_don=$id_ct_hoa_don;
    }

    public function getIdCtHoaDon()
    {
        return $this->id_ct_hoa_don;
    }

    public function setIdSanPham($id_san_pham)
    {
        $this->id_san_pham=$id_san_pham;
    }

    public function getIdSanPham()
    {
        return $this->id_san_pham;
    }

    public function setIdHoaDon($id_hoa_don)
    {
        $this->id_hoa_don=$id_hoa_don;
    }

    public function getIdHoaDon()
    {
        return $this->id_hoa_don;
    }

    public function setGia($gia)
    {
        $this->gia=$gia;
    }

    public function getGia()
    {
        return $this->gia;
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

    public function setState($state)
    {
        $this->state=$state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setSoLuongTra($so_luong_tra)
    {
        $this->so_luong_tra=$so_luong_tra;
    }

    public function getSoLuongTra()
    {
        return $this->so_luong_tra;
    }
    
}
