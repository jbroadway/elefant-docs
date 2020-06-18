# Request-response cycle

Requests in Elefant are all handled by the main `index.php` file, which uses `lib/Controller.php` to determine where to send requests for handling. Here is a diagram that illustrates the flow of a request through Elefant:

![Request flow in Elefant framework](https://www.elefantcms.com/files/docs/elefant_request_flow.png)

1. A new request is received by `index.php`, the front controller
2. The request is routed to the correct handler, e.g., `myapp/handler`
3. The handler determines how to handle the request, and calls on your model(s) to return the requested data
4. The handler renders the data with a view template and returns it to the front controller
5. The front controller optionally renders the final output with a layout template
6. The response is returned to the user

Next: [[:Mapping your routes]]
