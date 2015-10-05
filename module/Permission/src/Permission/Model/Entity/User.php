<?php
namespace Permission\Model\Entity;

class User
{
    
    protected $user_id;
    protected $id_kho;
    protected $username;
    protected $password;
    protected $display_name;
    protected $ho_ten;
    protected $dia_chi;
    protected $email;
    protected $state;
    protected $mo_ta;
    protected $dien_thoai_co_dinh;
    protected $di_dong;
    protected $twitter;
    

    public function exchangeArray($data)
    {
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->id_kho = (isset($data['id_kho'])) ? $data['id_kho'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->display_name = (isset($data['display_name'])) ? $data['display_name'] : null;
        $this->ho_ten = (isset($data['ho_ten'])) ? $data['ho_ten'] : null;
        $this->dia_chi = (isset($data['dia_chi'])) ? $data['dia_chi'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
        $this->mo_ta = (isset($data['mo_ta'])) ? $data['mo_ta'] : null;
        $this->dien_thoai_co_dinh = (isset($data['dien_thoai_co_dinh'])) ? $data['dien_thoai_co_dinh'] : null;
        $this->di_dong = (isset($data['di_dong'])) ? $data['di_dong'] : null;
        $this->twitter = (isset($data['twitter'])) ? $data['twitter'] : null;
    }

    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setUserId($user_id)
    {
        $this->user_id=$user_id;

    }
    public function getUserId()
    {
        return $this->user_id;           
    }

    public function setUsername($username)
    {
        $this->username=$username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        return $this->password=$password;
    }

    public function getPassword()
    {
        return $this->password;
    }



    public function setDisplayName($display_name)
    {
        $this->display_name=$display_name;
    }

    public function getDisplayName()
    {
        return $this->display_name;
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


    public function setTwitter($twitter)
    {
        $this->twitter=$twitter;
    }
    public function getTwitter()
    {
        return $this->twitter;
    }

    public function setIdKho($id_kho)
    {
        $this->id_kho=$id_kho;
    }

    public function getIdKho()
    {
        return $this->id_kho;
    }

    
}
