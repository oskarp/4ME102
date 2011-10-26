/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package ws_clientapp;

/**
 *
 * @author bvoadmin
 */
public class WS_clientapp {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
        int a = 6;
        int b = 8;
        int result = calculator(a, b);
        
        System.out.println("WS result: " + result);
    }
    
    private static int calculator (int a, int b){
        
        
        org.ws.application.WSApplication_Service ws = new org.ws.application.WSApplication_Service();
        org.ws.application.WSApplication port = ws.getWSApplicationPort();
        
        return port.calculator(a, b);
    }
}
