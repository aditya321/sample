<!DOCTYPE html>
<html>
<style>
    input, select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }


    button[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    div {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
    }
</style>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css"> <!-- load bootstrap via CDN -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> <!-- load jquery via CDN -->
<body style="margin-left: 30%; width: 40%;">

<h3>Please fill the form</h3>

<div>
    <form>
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="firstname" required placeholder="Your name..">

        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lastname" placeholder="Your last name.." required>

        <label for="country">Country</label>
        <input type="text" id="country" name="country" placeholder="Your Country..">

        <label for="city">City</label>
        <input type="text" id="city" name="city" placeholder="Your city..">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Your email.." required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Your password.." required>

        <label for="dob">Date Of Birth</label>
        <input type="date" id="dob" name="dob" placeholder="Your DOB.." required>

        <label for="resume">Resume</label>
        <input type="file" id="resume" name="resume" placeholder="Your Resume.." required>

        <label for="Image">Profile Image</label>
        <input type="file" id="image" name="image" placeholder="Your image.." required>

        <label for="Address">Address</label>
        <input type="text" id="address" name="address" placeholder="Your address..">

        <button class="btn-social"  type="submit" value="Submit">Submit</button>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var formData = new FormData();
        var Imageerror = false;
        var Pdferror = false;

        $('form').submit(function(event) {
            event.preventDefault();
            if(Imageerror){
                alert("please upload valid image");
                return false;
            }
            if(Pdferror){
                alert("please upload valid pdf for resume");
                return false;
            }
            formData.append("firstname", $('input[name=firstname]').val());
            formData.append("lastname", $('input[name=lastname]').val());
            formData.append("address", $('input[name=address]').val());
            formData.append("country", $('input[name=country]').val());
            formData.append("city", $('input[name=city]').val());
            formData.append("email", $('input[name=email]').val());
            formData.append("dob", $('input[name=dob]').val());
            formData.append("password", $('input[name=password]').val());
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax({
                type        : 'POST',
                url         : 'http://localhost:8300/submitForm',
                data        : formData,
                processData: false,
                contentType: false
            })
                .done(function(data) {
                    if(data.success == true){
                        alert(data.message);
                        location.reload();
                    }
                    else{
                        alert("Something went wrong!");
                    }
                });
        });
        $(function() {
            $("#image").change(function() {
                Imageerror = false;
                var file = this.files[0];
                var imagefile = file.type;
                var match= ["image/jpeg","image/png","image/jpg"];
                if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
                {
                    alert("Only jpeg, jpg and png Images type allowed");
                    Imageerror = true;
                    return false;
                }
                else
                {
                    var file = this.files[0];
                    formData.append("image", file);
                }
            });

            $("#resume").change(function() {
                Pdferror = false;
                var file = this.files[0];
                var imagefile = file.type;
                var match= ["application/pdf"];
                if(!(imagefile=="application/pdf"))
                {
                    alert("select valid pdf file");
                    Pdferror = true;
                    return false;
                }
                else
                {
                    var file = this.files[0];
                    formData.append("resume", file);
                }
            });
        });

    });
</script>
</body>
</html>
