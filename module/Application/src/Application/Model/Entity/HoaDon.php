<?php
namespace Application\Model\Entity;

class HoaDon
{
    protected $id_hoa_don;
    protected $id_khach_hang;
    protected $id_user;
    protected $ma_hoa_don;
    protected $ngay_xuat;
    protected $state;
   
    public function exchangeArray($data)
    {
        $this->id_hoa_don = (isset($data['id_hoa_don'])) ? $data['id_hoa_don'] : null;
        $this->id_khach_hang = (isset($data['id_khach_hang'])) ? $data['id_khach_hang'] : null;
        $this->id_user = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->ma_hoa_don = (isset($data['ma_hoa_don'])) ? $data['ma_hoa_don'] : null;
        $this->ngay_xuat = (isset($data['ngay_xuat'])) ? $data['ngay_xuat'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
        
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdHoaDon($id_hoa_don)
    {
        $this->id_hoa_don=$id_hoa_don;
    }

    public function getIdHoaDon()
    {
        return $this->id_hoa_don;
    }

    public function setIdKhachHang($id_khach_hang)
    {
        $this->id_khach_hang=$id_khach_hang;
    }

    public function getIdKhachHang()
    {
        return $this->id_khach_hang;
    }

    public function setIdUser($id_user)
    {
        $this->id_user=$id_user;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setMaHoaDon($ma_hoa_don)
    {
        $this->ma_hoa_don=$ma_hoa_don;
    }

    public function getMaHoaDon()
    {
        return $this->ma_hoa_don;
    }

    public function setNgayXuat($ngay_xuat)
    {
        $this->ngay_xuat=$ngay_xuat;
    }

    public function getNgayXuat()
    {
        return $this->ngay_xuat;
    }

    public function setState($state)
    {
        $this->state=$state;
    }

    public function getState()
    {
        return $this->state;
    }

    

    


    
}
