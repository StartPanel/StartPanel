<?php
    http_response_code(404);
    $page_name = "404";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>
<style>
    html {
    	overflow-y: scroll;
    }
</style>
<div class="container">
    <div class="row">
	    <div class="col-md-6 offset-md-3">
	        <div class="jumbotron">
    		    <center>
                    <h1>404</h1>
    		        <h4>The requested page could not be found.</h4>
    		        <div class="btn-group" role="group" aria-label="...">
    			        <a href="#" class="btn btn-primary btn-lg" onclick="window.history.back()">Back</a>
    			        <a href="/" class="btn btn-success btn-lg">Servers</a>
    		        </div>
    		    </center>
	        </div>
	    </div>
    </div>
</div>
<?php 
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>