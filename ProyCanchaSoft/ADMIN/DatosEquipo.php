<?php
class Equipo {
    public $Id_Equipo;
    public $Nom_Equipo;
    public $Color_Uniforme;
    public $Id_Capitan;

    function __construct($Id_Equipo, $Nom_Equipo, $Color_Uniforme, $Id_Capitan) {
        $this->Id_Equipo = $Id_Equipo;
        $this->Nom_Equipo = $Nom_Equipo;
        $this->Color_Uniforme = $Color_Uniforme;
        $this->Id_Capitan = $Id_Capitan;
    }
}

?>