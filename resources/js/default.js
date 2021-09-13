function isRequired(campo){
    var valor = $("#"+campo).val();
    if(valor != ""){
        return true;
    }
    alert("El campo "+ campo +" es requerido");
    $("#"+campo).focus();
    return false;
}
