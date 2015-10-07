<?php
namespace Application\Model\Entity;

class KhachHang
{
    
    protected $id_khach_hang;
    protected $id_kenh_phan_phoi;
    protected $ho_ten;
    protected $dia_chi;
    protected $email;
    protected $state;
    protected $mo_ta;
    protected $dien_thoai_co_dinh;
    protected $di_dong;
    protected $hinh_anh;
    protected $ngay_dang_ky;

    public function exchangeArray($data)
    {
        $this->id_khach_hang = (isset($data['id_khach_hang'])) ? $data['id_khach_hang'] : null;
        $this->id_kenh_phan_phoi = (isset($data['id_kenh_phan_phoi'])) ? $data['id_kenh_phan_phoi'] : null;
        $this->ho_ten = (isset($data['ho_ten'])) ? $data['ho_ten'] : null;
        $this->dia_chi = (isset($data['dia_chi'])) ? $data['dia_chi'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
        $this->mo_ta = (isset($data['mo_ta'])) ? $data['mo_ta'] : null;
        $this->dien_thoai_co_dinh = (isset($data['dien_thoai_co_dinh'])) ? $data['dien_thoai_co_dinh'] : null;
        $this->di_dong = (isset($data['di_dong'])) ? $data['di_dong'] : null;
        $this->hinh_anh = (isset($data['hinh_anh'])) ? $data['hinh_anh'] : null;
        $this->ngay_dang_ky = (isset($data['ngay_dang_ky'])) ? $data['ngay_dang_ky'] : null;
    }

    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdKhachHang($id_khach_hang)
    {
        $this->id_khach_hang=$id_khach_hang;
    }
    public function getIdKhachHang()
    {
        return $this->id_khach_hang;
    } 

    public function setIdKenhPhanPhoi($id_kenh_phan_phoi)
    {
        $this->id_kenh_phan_phoi=$id_kenh_phan_phoi;
    }
    public function getIdKenhPhanPhoi()
    {
        return $this->id_kenh_phan_phoi;
    }    

    public function setHoTen($ho_ten)
    {
        $this->ho_ten=$ho_ten;
    }
    public function getHoTen()
    {
        return $this->ho_ten;
    }
    
    public function setDiaChi($dia_chi)
    {
        $this->dia_chi=$dia_chi;
    }
    public function getDiaChi()
    {
        return $this->dia_chi;
    }

    public function setState($state)
    {
        $this->state=$state;
    }
    public function getState()
    {
        return $this->state;
    }

    public function setEmail($email)
    {
        $this->email=$email;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setMoTa($mo_ta)
    {
        $this->mo_ta=$mo_ta;
    }
    public function getMoTa()
    {
        return $this->mo_ta;
    }

    public function setDienThoaiCoDinh($dien_thoai_co_dinh)
    {
        $this->dien_thoai_co_dinh=$dien_thoai_co_dinh;
    }
    public function getDienThoaiCoDinh()
    {
        return $this->dien_thoai_co_dinh;
    }

    public function setDiDong($di_dong)
    {
        $this->di_dong=$di_dong;
    }
    public function getDiDong()
    {
        return $this->di_dong;
    }    

    public function setHinhAnh($hinh_anh)
    {
        $this->hinh_anh=$hinh_anh;
    }
    public function getHinhAnh()
    {
        return $this->hinh_anh;
    }

    public function setNgayDangKy($ngay_dang_ky)
    {
        $this->ngay_dang_ky=$ngay_dang_ky;
    }
    public function getNgayDangKy()
    {
        return $this->ngay_dang_ky;
    }
}
