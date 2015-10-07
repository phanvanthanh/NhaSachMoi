<?php
namespace Application\Model\Entity;

class PhieuNhap
{
    
    protected $id_phieu_nhap;
    protected $id_user;
    protected $id_nha_cung_cap;
    protected $ma_phieu_nhap;
    protected $ngay_nhap;
    protected $state;

    public function exchangeArray($data)
    {
        $this->id_phieu_nhap = (isset($data['id_phieu_nhap'])) ? $data['id_phieu_nhap'] : null;
        $this->id_user = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->id_nha_cung_cap = (isset($data['id_nha_cung_cap'])) ? $data['id_nha_cung_cap'] : null;
        $this->ma_phieu_nhap = (isset($data['ma_phieu_nhap'])) ? $data['ma_phieu_nhap'] : null;
        $this->ngay_nhap = (isset($data['ngay_nhap'])) ? $data['ngay_nhap'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
    }

    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdPhieuNhap($id_phieu_nhap)
    {
        $this->id_phieu_nhap=$id_phieu_nhap;
    }
    public function getIdPhieuNhap()
    {
        return $this->id_phieu_nhap;
    }
    public function setIdUser($id_user)
    {
        $this->id_user=$id_user;
    }
    public function getIdUser()
    {
        return $this->id_user;
    }
    public function setIdNhaCungCap($id_nha_cung_cap)
    {
        $this->id_nha_cung_cap=$id_nha_cung_cap;
    }
    public function getIdNhaCungCap()
    {
        return $this->id_nha_cung_cap;
    } 

    public function setMaPhieuNhap($ma_phieu_nhap)
    {
        $this->ma_phieu_nhap=$ma_phieu_nhap;
    }
    public function getMaPhieuNhap()
    {
        return $this->ma_phieu_nhap;
    } 
    public function setNgayNhap($ngay_nhap)
    {
        $this->ngay_nhap=$ngay_nhap;
    }
    public function getNgayNhap()
    {
        return $this->ngay_nhap;
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
