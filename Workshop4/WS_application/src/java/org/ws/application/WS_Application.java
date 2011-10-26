/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package org.ws.application;

import javax.jws.WebService;
import javax.jws.WebMethod;
import javax.jws.WebParam;

/**
 *
 * @author bvoadmin
 */
@WebService(serviceName = "WS_Application")
public class WS_Application {

    /** This is a sample web service operation */
    @WebMethod(operationName = "hello")
    public String hello(@WebParam(name = "name") String txt) {
        return "Hello " + txt + " !";
    }

    /**
     * Web service operation
     */
    @WebMethod(operationName = "calculator")
    public int calculator(@WebParam(name = "a") int a, @WebParam(name = "b") int b) {
        //TODO write your implementation code here:
        
        int c = a +b;
        return c;
    }
}
