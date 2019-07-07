console.log(localStorage.getItem('1'))
document.getElementById('userLogin').innerHTML = localStorage.getItem('1');




function upload() {
    // Define the folder path for this example.
    var serverRelativeUrlToFolder = 'http://dataplatform.000webhostapp.com/api/task';

    // Get test values from the file input and text input page controls.
    var fileInput = jQuery('#getFile');
    var newName = jQuery('#displayName').val();
    var fileCount = fileInput[0].files.length;
    // Get the server URL.
    var serverUrl = _spPageContextInfo.webAbsoluteUrl;
    var filesUploaded = 0;
        // Initiate method calls using jQuery promises.
        // Get the local file as an array buffer.
        var getFile = getFileBuffer();
        getFile.done(function (arrayBuffer,i) {

            // Add the file to the SharePoint folder.
            var addFile = addFileToFolder(arrayBuffer);
            addFile.done(function (file, status, xhr) {
                //$("#msg").append("<div>File : "+file.d.Name+" ... uploaded sucessfully</div>");
                filesUploaded++;
                if(fileCount == filesUploaded){
                    alert("All files uploaded successfully");
                    //$("#msg").append("<div>All files uploaded successfully</div>");
                    $("#getFile").value = null;
                    filesUploaded = 0;
                }
            });
            addFile.fail(onError);
        });
        getFile.fail(onError);

    }

    // Get the local file as an array buffer.
    function getFileBuffer(i) {
        var deferred = jQuery.Deferred();
        var reader = new FileReader();
        reader.onloadend = function (e) {
            deferred.resolve(e.target.result,i);
        }
        reader.onerror = function (e) {
            deferred.reject(e.target.error);
        }
        reader.readAsArrayBuffer(fileInput[0].files[i]);
        return deferred.promise();
    }

    // Add the file to the file collection in the Shared Documents folder.
    function addFileToFolder(arrayBuffer,i) {
    var index = i;

        // Get the file name from the file input control on the page.
        var fileName = fileInput[0].files[index].name;
        // Construct the endpoint.
        var fileCollectionEndpoint = String.format(
                "http://dataplatform.000webhostapp.com/api/task",
                serverUrl, serverRelativeUrlToFolder, fileName);

        // Send the request and return the response.
        // This call returns the SharePoint file.
        return jQuery.ajax({
            url: fileCollectionEndpoint,
            type: "POST",
            data: arrayBuffer,
            processData: false,
            headers: {
                "accept": "application/json;odata=verbose",
                "X-RequestDigest": jQuery("#__REQUESTDIGEST").val(),
                "content-length": arrayBuffer.byteLength
            }
        });
    
}

// Display error messages. 
function onError(error) {
    alert(error.responseText);
}