<?php
if (isset($_POST['submit'])) {
	if (isset($_POST['url'])) {
		$url = $_POST['url'];
	} else {
		header("Location: index.php");
	}
} else {
	header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Azure Submission 2 - Analyze</title>
  <script src="./jquery.min.js"></script>
	<style type="text/css">
		body { background-color: #fff; border-top: solid 10px #000;
		    color: #333; font-size: .85em; margin: 20; padding: 20;
		    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
		}
		h1, h2, h3{ color: #000; margin-bottom: 0; padding-bottom: 0; }
		h1 { font-size: 2em; }
		h2 { font-size: 1.75em; }
		h3 { font-size: 1.2em; }
		table { margin-top: 0.75em; }
		th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
		td { padding: 0.25em 2em 0.25em 0em; border: 0 none;}
	</style>
</head>
<body>
    <script type="text/javascript">
        $(document).ready(function () {
        // **********************************************
        // *** Update or verify the following values. ***
        // **********************************************
        // Replace <Subscription Key> with your valid subscription key.
        var subscriptionKey = "3652dacb4b8a48078851347e8a499b87";
        // You must use the same Azure region in your REST API method as you used to
        // get your subscription keys. For example, if you got your subscription keys
        // from the West US region, replace "westcentralus" in the URL
        // below with "westus".
        //
        // Free trial subscription keys are generated in the "westus" region.
        // If you use a free trial subscription key, you shouldn't need to change
        // this region.
        var uriBase ="https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
        // Request parameters.
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };
        // Display the image.
        var sourceImageUrl = "<?php echo $url ?>";
        document.querySelector("#sourceImage").src = sourceImageUrl;
        // Make the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", subscriptionKey);
            },
            type: "POST",
            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })
        .done(function(data) {
            // Show formatted JSON on webpage.
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
						// $("#confidence").text(data.description.captions[0].confidence);
            $("#result").text(data.description.captions[0].text);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
            errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
            jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });
    });
  </script>

<a href="./"><h3><span><</span>--back</h3></a>
<h1>So we describe this is a picture</h1>
<!-- <p id="confidence">??%</p> <p> look like </p> -->
<h2>"<span id="result">hmm.. wait a second. . .</span>"</h2>
<br>
<div>
	<div id="jsonOutput" style="width:600px; display:table-cell;">
		<b>Response:</b>
		<br><br>
		<textarea id="responseTextArea" class="UIInput"
		style="width:580px; height:400px;" readonly=""></textarea>
	</div>
	<div style="width:420px; display:table-cell;">
		<b>Source Image:</b>
		<br><br>
		<img id="sourceImage" width="400" />
	</div>
	<br>
</div>
</body>
</html>
