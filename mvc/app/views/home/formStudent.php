<!DOCTYPE html>
<html>
<head>
  <style>
    .error {color: #FF0000;}
  </style>
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-3">
              <div>
                      <form id = "idForm" class="contact-form" method="post" action = "../home/addStudent">
                              <div class="form-group">
                                      <input class="form-control" type="text" name="name" placeholder="Fullname">
                                      <span class="error">* <?php //echo $nameErr?></span>
                              </div>
                              <div class="form-group">
                                      <input class="form-control" type="text" name="phone" placeholder="Age">
                                      <span class="error">* <?php //echo $phoneErr?></span>
                              </div>
                              <div class="form-group">
                                      <input class="form-control" type="text" name="email" placeholder="Email">
                                      <span class="error">* <?php //echo $emailErr?></span>
                              </div>  
                              <div class="form-group">
                                      <input class="form-control" type="text" name="class" placeholder="Class">
                                      <span class="error">* <?php //echo $emailErr?></span>
                              </div>  
                                      <button class="btn btn-primary" type="submit" name="submit" onclick="return confirm('Want to Add?')">Add </button>
                      
                      </form>
              </div>
    </div>
    <div class="col-9">
                  
    </div>   
</div>  
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
      
      $("#idForm").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize() // serializes the form's elements.
            success: function(data)
            {
              
                  alert(data);
               
                  
                 // show response from the php script.
            }
        });


      });
    </script>
    
</body>
</html>
