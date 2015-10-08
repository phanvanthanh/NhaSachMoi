<?php
namespace Application\Model\Entity;

class SanPham
{
    
    protected $id_san_pham;
    protected $id_kho;
    protected $id_don_vi_tinh;
    protected $id_loai_san_pham;
    protected $id_barcode;
    protected $ma_vach;
    protected $ma_san_pham;
    protected $ten_san_pham;
    protected $mo_ta;
    protected $hinh_anh;
    protected $nhan;
    protected $ton_kho;
    protected $loai_gia;
    protected $gia_nhap;
    protected $gia_bia;
    protected $chiet_khau;
   
    

    public function exchangeArray($data)
    {
        $this->id_san_pham = (isset($data['id_san_pham'])) ? $data['id_san_pham'] : null;
        $this->id_kho = (isset($data['id_kho'])) ? $data['id_kho'] : null;
        $this->id_don_vi_tinh = (isset($data['id_don_vi_tinh'])) ? $data['id_don_vi_tinh'] : null;
        $this->id_loai_san_pham = (isset($data['id_loai_san_pham'])) ? $data['id_loai_san_pham'] : null;
        $this->ma_san_pham = (isset($data['ma_san_pham'])) ? $data['ma_san_pham'] : null;
        $this->ten_san_pham = (isset($data['ten_san_pham'])) ? $data['ten_san_pham'] : null;
        $this->mo_ta = (isset($data['mo_ta'])) ? $data['mo_ta'] : null;
        $this->hinh_anh = (isset($data['hinh_anh'])) ? $data['hinh_anh'] : null;
        $this->nhan = (isset($data['nhan'])) ? $data['nhan'] : null;
        $this->ton_kho = (isset($data['ton_kho'])) ? $data['ton_kho'] : null;
        $this->loai_gia = (isset($data['loai_gia'])) ? $data['loai_gia'] : null;
        $this->gia_nhap = (isset($data['gia_nhap'])) ? $data['gia_nhap'] : null;
        $this->gia_bia = (isset($data['gia_bia'])) ? $data['gia_bia'] : null;
        $this->chiet_khau = (isset($data['chiet_khau'])) ? $data['chiet_khau'] : null;
        $this->ma_vach = (isset($data['ma_vach'])) ? $data['ma_vach'] : null;
        $this->id_barcode = (isset($data['id_barcode'])) ? $data['id_barcode'] : null;

        
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdSanPham($id_san_pham)
    {
        $this->id_san_pham=$id_san_pham;
    }

    public function getIdSanPham()
    {
        return $this->id_san_pham;
    }

    public function setIdKho($id_kho)
    {
        $this->id_kho=$id_kho;
    }

    public function getIdKho()
    {
        return $this->id_kho;
    }

    public function setIdDonViTinh($id_don_vi_tinh)
    {
        $this->id_don_vi_tinh=$id_don_vi_tinh;
    }

    public function getIdDonViTinh()
    {
        return $this->id_don_vi_tinh;
    }

    public function setIdLoaiSanPham($id_loai_san_pham)
    {
        $this->id_loai_san_pham=$id_loai_san_pham;
    }

    public function getIdLoaiSanPham()
    {
        return $this->id_loai_san_pham;
    }

    public function setMaSanPham($ma_san_pham)
    {
        $this->ma_san_pham=$ma_san_pham;
    }

    public function getMaSanPham()
    {
        return $this->ma_san_pham;
    }

    public function setTenSanPham($ten_san_pham)
    {
        $this->ten_san_pham=$ten_san_pham;
    }

    public function getTenSanPham()
    {
        return $this->ten_san_pham;
    }

    public function setMoTa($mo_ta)
    {
        $this->mo_ta=$mo_ta;
    }

    public function getMoTa()
    {
        return $this->mo_ta;
    }

    public function setHinhAnh($hinh_anh)
    {
        $this->hinh_anh=$hinh_anh;
    }

    public function getHinhAnh()
    {
        return $this->hinh_anh;
    }


    public function setNhan($nhan)
    {
        $this->nhan=$nhan;
    }

    public function getNhan()
    {
        return $this->nhan;
    }


    public function setTonKho($ton_kho)
    {
        $this->ton_kho=$ton_kho;
    }

    public function getTonKho()
    {
        return $this->ton_kho;
    }

    public function setLoaiGia($loai_gia)
    {
        $this->loai_gia=$loai_gia;
    }

    public function getLoaiGia()
    {
        return $this->loai_gia;
    }

    public function setGiaNhap($gia_nhap)
    {
        $this->gia_nhap=$gia_nhap;
    }

    public function getGiaNhap()
    {
        return $this->gia_nhap;
    }

    public function setGiaBia($gia_bia)
    {
        $this->gia_bia=$gia_bia;
    }

    public function getGiaBia()
    {
        return $this->gia_bia;
    }

    public function setChietKhau($chiet_khau)
    {
        $this->chiet_khau=$chiet_khau;
    }

    public function getChietKhau()
    {
        return $this->chiet_khau;
    }

    public function setMaVach($ma_vach)
    {
        $this->ma_vach=$ma_vach;
    }

    public function getMaVach()
    {
        return $this->ma_vach;
    }

    public function setIdBarcode($id_barcode)
    {
        $this->id_barcode=$id_barcode;
    }

    public function getIdBarcode()
    {
        return $this->id_barcode;
    }

    
}
