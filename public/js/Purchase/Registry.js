function Registry() {
    var table;
    this.init = function () {
//        table = this.table();

        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#btnNew").click(function () {
            $(".input-courses").cleanFields();
            $("#modalNew").modal("show");
        });


        $("#btnCopy").click(this.copyInfo)

        $("#state_id").change(function () {
            $("#state_id_building").val($(this).val()).change();
        })


        $("#date_birth").datetimepicker({format: 'm/d/y', timepicker: false});

        $("#saveDate").click(function () {
            $("#date_selected").val($("#datetimepicker3").val());
            $("#modaldui").modal("hide");
            $("#frm").submit();
        });
        $("#complete").click(function () {
            var validate = $(".input-category").validate();
            if (validate.length == 0) {

                if ($("#email").val() == $("#confirm_email").val()) {
                    if ($("#date_selected").val() != '') {
                        $("#frm").submit();
                    } else {
                        $("#modaldui").modal("show");
                        $('#datetimepicker3').datetimepicker({
                            format: 'Y/m/d H:i',
                        });
                    }
                } else {
                    toastr.error("Email and confirmation must be equals!");
                }
            } else {
                toastr.error("Fields Required!");
            }
        })


    }

    this.copyInfo = function () {
        if ($(this).is(":checked")) {
            $("#zip_code_building").val($("#zip_code").val());
            $("#city_id_building").val($("#city_id").val());
            $("#address_building").val($("#address").val());
            $("#last_name_building").val($("#last_name").val());
            $("#name_building").val($("#name").val());
        }
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
                    obj.setList(data.data);
                }
            }, error: function (err) {

            }
        })
    }

    this.setList = function (data) {
        var html = "";
        $.each(data, function (i, val) {
            html += '<div class="panel panel-default">';
            html += '<div class="panel-heading">';
            html += '<div class="row"><div class="col-lg-5">' + val[0].course + '</div><div class="col-lg-4">' + val[0].location + '</div></div>';
            html += '</div>'
            html += '<table class="table table-condensed" style="wdth:100%">'
            $.each(val, function (i, value) {
                html += '<tr>';
                html += '<td align="left" width="30%"> ';
                html += value.daytext + ',' + value.weekday.day + ' /' + value.weekday.month + '.....' + value.hour + ' - ' + value.finished + '</td>';
                html += '<td align="center">' + value.address + '</td>';
                html += '<td align="center"><a class="btn btn-success" href="clients/' + value.course_id + '">Register</button></td>';
                html += '</tr>'
            });

            html += '</table></div>';
        })


        $("#content-list").html(html);
    }

}

var obj = new Registry();
obj.init();