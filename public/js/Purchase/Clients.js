function Clients() {
    var table;
    this.init = function () {
        

        table = this.table();
        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#btnNew").click(function () {
            $(".input-courses").cleanFields();
            $("#modalNew").modal("show");
        });
    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-courses").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "courses";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "courses/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        $("#modalNew").modal("hide");
                        $(".input-courses").setFields({data: data});
                        table.ajax.reload();
                        toastr.success(msg);
                    }
                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

    this.show = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/courses/" + id + "/edit";
        $("#modalNew").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $(".input-courses").setFields({data: data});
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/courses/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        table.ajax.reload();
                        toastr.warning("Ok");
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.table = function () {
        $.ajax({
            url: "clients/getList",
            method: "get",
            dataType: 'JSON',
            success: function (data) {
                if (data.success == true) {

                    toastr.warning("Ok");
                }
            }, error: function (err) {

            }
        })
    }

}

var obj = new Clients();
obj.init();