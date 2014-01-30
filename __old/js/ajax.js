        //<![CDATA[
            /* This function Creates a AJAX object, depending of which our Browser is */
            function RemoteRequestObject() {
                var A = false;

                try {
                    A = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(e) {
                    try {
                        A = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch(err) {
                        A = false;
                    }
                }	
                if(!A && (typeof(XMLHttpRequest) != 'undefined'))
                    A = new XMLHttpRequest();  //-standard xmlhttprequest!

                return A;
            }
        //]]>