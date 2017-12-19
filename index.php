<!DOCTYPE html>
<html>
<head>
    <title>
        
    </title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .top_20 {
            margin-top: 20%;
        }
        .form {
            /*background: #fff6f6;*/
            padding: 50px;
            border-radius: 2px;
            border: 1px #ace5b6 solid;
        }

        .icon i {
            font-size: 70px;
            color: green;
        }

        .icon {
            margin-bottom: 5px;
        }

        .container {
            color: #fff;
        }

        .hidden{
            display: none;
        }

        .red {
            border: 1px red solid;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
</head>
<body>

    <div class="container">
        <br/>
        <form class="form" action="file.php" method="post"> 
            <center><span class="icon"><i class="fa fa-repeat"></i></span></center>
            <br/>
              <div class="form-group ">
                <input type="text" class="form-control date" name="date" value="<?= date('Y-m-d') ?>" placeholder="Email">
              </div>

            <center>
                <button type="submit" class="btn btn-success"> Export <i class="fa fa-spinner fa-spin hidden"></i> </button>
            </center>
            <br/>
            <center>
                <a href="" class=" hidden download" > Downlaod Compressed file </a>
            </center>
        </form>
    </div>

    <script>
        $('.date').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",

        });

        $('.form').on('submit', function(e)
        {
            e.preventDefault();

            var $this = $(this);

            $('.fa-spin').removeClass('hidden');

            $.ajax({
                url : $this.attr('action'),
                type: $this.attr('method'),
                data: new FormData($this[0]),
                processData: false,
                contentType: false,
                success : function(data) {
                    data = JSON.parse(data);
                    console.log(data.file);
                    if(data.status == 1) {
                        $('.download').removeClass('hidden');
                        $('.download').attr('href', data.file);
                    } else {
                        $('.form').addClass('red');
                        $('.form').find('.form-group').addClass('has-error');
                    }

                    $('.fa-spin').addClass('hidden');
                }
            });
        });
    </script>
</body>
</html>