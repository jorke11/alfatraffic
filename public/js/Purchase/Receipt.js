function Receipt() {
    var table;

    var canvas = document.getElementById("canvas");
    var context = canvas.getContext("2d");


    this.init = function () {

        $("#digital").click(function () {
            if ($("#digital").is(":checked")) {
                $("#name,#type_form").attr("disabled", false);
            }
        })
        $("#sign").click(function () {
            if ($("#sign").is(":checked")) {
                $("#name,#type_form").attr("disabled", true);
            }
        })

        $("#name").keyup(function () {
            $("#name_preview").val($(this).val());
        })

        $("#type_form").change(function () {
            $("#name_preview").removeClass("pacifico")
            $("#name_preview").removeClass("indie")
            $("#name_preview").removeClass("dancing")
            $("#name_preview").removeClass("tangerine")


            if ($(this).val() == 1) {
                $("#name_preview").addClass("pacifico")
            } else if ($(this).val() == 2) {
                $("#name_preview").addClass("indie")
            } else if ($(this).val() == 3) {
                $("#name_preview").addClass("dancing")
            } else if ($(this).val() == 4) {
                $("#name_preview").addClass("tangerine")
            }
        })

        this.paint();

    }

    this.paint = function () {
        var radius = 2;

        var dragging = false;
//        canvas.width = window.innerWidth;
        canvas.width = canvas.offsetWidth;
//        canvas.height = window.innerHeight;
        canvas.height = canvas.offsetHeight;

        context.lineWidth = radius * 2;

        console.log(canvas.offsetWidth)

        var putPoint = function (e) {
            if (dragging) {
                context.lineTo(e.offsetX, e.offsetY);
                context.stroke();
                context.beginPath();
                //context.arc(e.clientX,e.ClientY,radius,0,Math.PI*2);
                context.arc(e.offsetX, e.offsetY, radius, 0, Math.PI * 2);
                context.fill();
                context.beginPath();
                context.moveTo(e.offsetX, e.offsetY)
            }
        };

        var engage = function (e) {
            dragging = true;
            putPoint(e);
        }


        var disengage = function () {
            dragging = false;
            context.beginPath();
        }


        canvas.addEventListener("mousedown", engage);
        canvas.addEventListener("mousemove", putPoint);
        canvas.addEventListener("mouseup", disengage);
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

}

var obj = new Receipt();
obj.init();