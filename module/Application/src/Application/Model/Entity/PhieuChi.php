<?php
namespace Application\Model\Entity;

class PhieuChi
{
    
    protected $id_phieu_chi;
    protected $id_user;
    protected $id_cong_no;
    protected $ma_phieu_chi;
    protected $ly_do;
    protected $so_tien;
    protected $ngay_thanh_toan;

    public function exchangeArray($data)
    {
        $this->id_phieu_chi = (isset($data['id_phieu_chi'])) ? $data['id_phieu_chi'] : null;
        $this->id_user = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->id_cong_no = (isset($data['id_cong_no'])) ? $data['id_cong_no'] : null;
        $this->ma_phieu_chi = (isset($data['ma_phieu_chi'])) ? $data['ma_phieu_chi'] : null;
        $this->ly_do = (isset($data['ly_do'])) ? $data['ly_do'] : null;
        $this->so_tien = (isset($data['so_tien'])) ? $data['so_tien'] : null;
        $this->ngay_thanh_toan = (isset($data['ngay_thanh_toan'])) ? $data['ngay_thanh_toan'] : null;
    }

    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    public function setIdPhieuChi($id_phieu_chi)
    {
        $this->id_phieu_chi=$id_phieu_chi;
    }
    public function getIdPhieuChi()
    {
        return $this->id_phieu_chi;
    }

    public function setIdUser($id_user)
    {
        $this->id_user=$id_user;
    }
    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdCongNo($id_cong_no)
    {
        $this->id_cong_no=$id_cong_no;
    }
    public function getIdCongNo()
    {
        return $this->id_cong_no;
    }

    public function setMaPhieuChi($ma_phieu_chi)
    {
        $this->ma_phieu_chi=$ma_phieu_chi;
    }
    public function getMaPhieuChi()
    {
        return $this->ma_phieu_chi;
    }

    public function setLyDo($ly_do)
    {
        $this->ly_do=$ly_do;
    }
    public function getLyDo()
    {
        return $this->ly_do;
    }

    public function setSoTien($so_tien)
    {
        $this->so_tien=$so_tien;
    }
    public function getSoTien()
    {
        return $this->so_tien;
    } 

    public function setNgayThanhToan($ngay_thanh_toan)
    {
        $this->ngay_thanh_toan=$ngay_thanh_toan;
    }
    public function getNgayThanhToan()
    {
        return $this->ngay_thanh_toan;
    }  
}
