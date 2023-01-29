if ($data->get("{{campo}}") != "") {
       $where->where("{{campo}}","like", "%".$data->get("{{campo}}")."%");
}
