<?php
namespace Scrilex;

/**
 * Twig Extension to add the eval function to evaluate twig code passed into a template
 */
class EvalExtension extends \Twig_Extension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'eval';
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'eval' => new \Twig_Function_Method($this, 'evaluateString', array(
                'needs_environment' => true,
                'needs_context'     => true,
            )),
        );
    }

    /**
     * Loads a string template and returns the rendered version
     *
     * @param  Twig_Environment $env
     * @param  array             $context
     * @param  string            $string  The string template to load
     * @return string
     */
    public function evaluateString(\Twig_Environment $env, $context, $string)
    {
        $loader = $env->getLoader();
        $parsed = $this->parseString($env, $context, $string);
        $env->setLoader($loader);
        return $parsed;
    }
    
    /**
     * Sets the parser for the environment to Twig_Loader_String, and parsed the string $string.
     * 
     * @param \Twig_Environment $environment
     * @param array $context
     * @param string $string
     * @return string 
     */
    protected function parseString( \Twig_Environment $environment, $context, $string ) {
        $environment->setLoader( new \Twig_Loader_String( ) );
        return $environment->render( $string, $context );
    }
}