<?php
namespace Application\Model\Entity;

class PhieuDoiTra
{
    protected $id_phieu_doi_tra;
    protected $id_hoa_don;
    protected $id_user;
    protected $ngay_xuat;
    protected $state;
   
    public function exchangeArray($data)
    {
        $this->id_phieu_doi_tra = (isset($data['id_phieu_doi_tra'])) ? $data['id_phieu_doi_tra'] : null;
        $this->id_hoa_don = (isset($data['id_hoa_don'])) ? $data['id_hoa_don'] : null;
        $this->id_user = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->ngay_xuat = (isset($data['ngay_xuat'])) ? $data['ngay_xuat'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
        
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdPhieuDoiTra($id_phieu_doi_tra){
        $this->id_phieu_doi_tra=$id_phieu_doi_tra;
    }

    public function getIdPhieuDoiTra(){
        return $this->id_phieu_doi_tra;
    }

    public function setIdHoaDon($id_hoa_don)
    {
        $this->id_hoa_don=$id_hoa_don;
    }

    public function getIdHoaDon()
    {
        return $this->id_hoa_don;
    }
    
    public function setIdUser($id_user)
    {
        $this->id_user=$id_user;
    }

    public function getIdUser()
    {
        return $this->id_user;
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
