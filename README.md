Zend Framework OAuth 2.0 example application
================
Example OAuth 2.0 consumer application for Zend Framework.

Using Authorization Code Grant flow on Facebook. 

Get it working
----------------
- Register your own OAuth consumer at https://developers.facebook.com/apps
- Replace CLIENT_ID and CLIENT_SECRET in application/controllers/FacebookController.php
- Configure own vhost on your Apache to url http://oauth2.local
- Enjoy!

Notes
----------------
- No layout, just simple views
- Probably not valid HTML, made just as simple preview
- Error states are not properly handled
- No refresh token handling

References
----------------
1. OAuth 2.0 draft v23 - http://tools.ietf.org/html/draft-ietf-oauth-v2-23
2. Authentication on Facebook - https://developers.facebook.com/docs/authentication/
3. Own bachelor thesis - http://o.vlastovka.eu/download/machuon1_2012bach.pdf
4. Presentation (in Czech) - http://www.slideshare.net/ondram/oauth-20-a-zend-framework