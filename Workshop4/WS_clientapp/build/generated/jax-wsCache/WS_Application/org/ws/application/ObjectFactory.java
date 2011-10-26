
package org.ws.application;

import javax.xml.bind.JAXBElement;
import javax.xml.bind.annotation.XmlElementDecl;
import javax.xml.bind.annotation.XmlRegistry;
import javax.xml.namespace.QName;


/**
 * This object contains factory methods for each 
 * Java content interface and Java element interface 
 * generated in the org.ws.application package. 
 * <p>An ObjectFactory allows you to programatically 
 * construct new instances of the Java representation 
 * for XML content. The Java representation of XML 
 * content can consist of schema derived interfaces 
 * and classes representing the binding of schema 
 * type definitions, element declarations and model 
 * groups.  Factory methods for each of these are 
 * provided in this class.
 * 
 */
@XmlRegistry
public class ObjectFactory {

    private final static QName _HelloResponse_QNAME = new QName("http://application.ws.org/", "helloResponse");
    private final static QName _Hello_QNAME = new QName("http://application.ws.org/", "hello");
    private final static QName _Calculator_QNAME = new QName("http://application.ws.org/", "calculator");
    private final static QName _CalculatorResponse_QNAME = new QName("http://application.ws.org/", "calculatorResponse");

    /**
     * Create a new ObjectFactory that can be used to create new instances of schema derived classes for package: org.ws.application
     * 
     */
    public ObjectFactory() {
    }

    /**
     * Create an instance of {@link Calculator }
     * 
     */
    public Calculator createCalculator() {
        return new Calculator();
    }

    /**
     * Create an instance of {@link Hello }
     * 
     */
    public Hello createHello() {
        return new Hello();
    }

    /**
     * Create an instance of {@link HelloResponse }
     * 
     */
    public HelloResponse createHelloResponse() {
        return new HelloResponse();
    }

    /**
     * Create an instance of {@link CalculatorResponse }
     * 
     */
    public CalculatorResponse createCalculatorResponse() {
        return new CalculatorResponse();
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link HelloResponse }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://application.ws.org/", name = "helloResponse")
    public JAXBElement<HelloResponse> createHelloResponse(HelloResponse value) {
        return new JAXBElement<HelloResponse>(_HelloResponse_QNAME, HelloResponse.class, null, value);
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link Hello }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://application.ws.org/", name = "hello")
    public JAXBElement<Hello> createHello(Hello value) {
        return new JAXBElement<Hello>(_Hello_QNAME, Hello.class, null, value);
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link Calculator }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://application.ws.org/", name = "calculator")
    public JAXBElement<Calculator> createCalculator(Calculator value) {
        return new JAXBElement<Calculator>(_Calculator_QNAME, Calculator.class, null, value);
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link CalculatorResponse }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://application.ws.org/", name = "calculatorResponse")
    public JAXBElement<CalculatorResponse> createCalculatorResponse(CalculatorResponse value) {
        return new JAXBElement<CalculatorResponse>(_CalculatorResponse_QNAME, CalculatorResponse.class, null, value);
    }

}
