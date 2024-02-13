// Find all forms in page
var forms = document.forms;

for (const form of forms) {
    form.addEventListener('submit', function(event) {

        // Get all inputs in form
        var inputs = form.getElementsByTagName('input');
        var data = {};

        // Get all inputs values
        for (const input of inputs) {
            data[input.name] = input.value;
        }

        // Send data to server
        fetch(window.location.origin + '/index.php/wp-json/pb-configurator/v1/send-alert', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
    });
}