document.querySelectorAll(".recharge_edit").forEach(function (component) {
    component.addEventListener("click", function (e) {
        var idrecarga = this.getAttribute("data-idrecarga");
        var amount = this.getAttribute("data-amount");
        var idchannel = this.getAttribute("data-idchannel");
        var idbank = this.getAttribute("data-idbank");
        document.getElementById("id_label_recarga").innerHTML = idrecarga + " del monto " +amount;
        document.getElementById("id_bank_edit").value = idbank;
        document.getElementById("id_channel_edit").value = idchannel;
        document.getElementById("amount_edit").value = amount;
        document.getElementById("id_recharge_edit").value = idrecarga;

        var modal = new bootstrap.Modal(document.getElementById("modaleditar"));
        modal.show();
    });
});

document.querySelectorAll(".recharge_anular").forEach(function (component) {
    component.addEventListener("click", function (e) {
        var idrecargaAnul = this.getAttribute("data-idrecarga");
        document.getElementById("id_label_recarga_anular").innerHTML = 'ID ' +idrecargaAnul;
        document.getElementById("id_recharge_anular").value = idrecargaAnul;

        var modal = new bootstrap.Modal(document.getElementById("modalanular"));
        modal.show();
    });
});