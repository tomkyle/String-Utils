<?php
/**
 * This file is part of tomkyle/string-utils.
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
namespace tomkyle;

use \tomkyle\StringProvider;

/**
 * TextInterpolation - Simple template string interpolator
 *
 * You may want to define a subclass with predefined template string,
 * or you may instantiate and configure a new TextInterpolation object
 * each time you need one.
 *
 * The interpolation engine is inspired by the
 * PSR-3-Log example implementation of placeholder interpolation.
 * See: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
 *
 * Usage:
 *
 *   <?php
 *   # Repeated usage, using __invoke method
 *   $t1 = new TextInterpolation('Hello {foo}');
 *   echo $t1( ['foo'=>'John']);
 *   echo $t1( ['foo'=>'William']);
 *   echo $t1( ['foo'=>'Sly']);
 *
 *   #Shortest usage
 *   echo new TextInterpolation('Hello {foo}', ['foo'=>'John Doe']);
 *
 *   # Full API Usage
 *   $t2 = new TextInterpolation;
 *   $t2->setTemplate('Goodbye {foo}')
 *   $t2->setContext(['foo'=>'John Doe']);
 *   echo $t2;
 *
 *   # The same, using Fluent API:
 *   $t3 = new TextInterpolation;
 *   echo $t3->setTemplate('Goodbye {foo}')
 *           ->setContext(['foo'=>'John Doe']);
 *   ?>
 *
 * @author   Carsten Witt <tomkyle@posteo.de>
 */
class TextInterpolation implements StringProvider
{

  /**
   * The template string. Override in subclasses.
   * @var string
   */
    public $template = '';


    /**
     * Array with template field names and values.
     * Configure with setContext method.
     * @var string
     */
    public $context  = array();


    /**
     * Array with default template field names and values.
     * @var string
     */
    public $defaults  = array();


    /**
     * Accepts up to two parameters, either:
     *
     *   - a template string to work with
     *   - a context array to work with
     *   - Template string and context array
     *   - No parameters at all, for later configuration
     *
     * @param string|array $template Template string or context array
     * @param array  $context  Context array, default: array
     *
     * @uses  setTemplate()
     * @uses  setContext()
     */
    public function __construct( $template = null, array $context = array() )
    {
        if (is_string($template)) {
            $this->setTemplate( $template );
        } elseif (is_array($template)
        and empty($context)) {
            $context = $template;
        } else {
            return;
        }

        $this->setContext( $context );
    }


    /**
     * @return string Interpolated text
     * @uses   interpolate()
     * @uses   getContext()
     */
    public function __toString()
    {
        return $this->interpolate( $this->getTemplate(), $this->getContext() );
    }


    /**
     * @param  array $context Context array, default: array
     * @return string Interpolated text
     *
     * @uses   interpolate()
     * @uses   getContext()
     * @uses   setContext()
     */
    public function __invoke( array $context = array())
    {
        $this->setContext( $context );
        return $this->interpolate( $this->getTemplate(), $this->getContext() );
    }



    /**
     * @param  array $context Context array, default: array
     * @return TextInterpolation Fluent Interface
     * @uses   $context
     */
    public function setContext( array $context = array() )
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return array The context array currently used
     * @uses   $context
     */
    public function getContext( )
    {
        return $this->context;
    }



    /**
     * @param  array $context Another context array to be merged
     * @return TextInterpolation Fluent Interface
     * @uses   $context
     */
    public function mergeContext( array $context = array() )
    {
        $this->context = array_merge($this->context, $context);
        return $this;
    }




    /**
     * @param  string $template Template string
     * @return TextInterpolation Fluent Interface
     * @uses   $template
     */
    public function setTemplate( $template )
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return string The template string currently used
     * @uses   $template
     */
    public function getTemplate()
    {
        return $this->template;
    }



    /**
     * Interpolates context values into the template placeholders.
     *
     * About some special values:
     *
     *   - NULL and Boolean values are converted as NULL or TRUE/FALSE resp.,
     *   - Objects are "string-casted" by interpolateObject method,
     *   - Float numbers are "string-casted" by interpolateFloat method,
     *
     * @param  array $context Context array, default: array
     * @return string Interpolated text
     *
     * @uses   $defaults
     * @uses   getTemplate()
     * @uses   interpolateObject()
     * @uses   interpolateNum()
     *
     * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
     */
    public function interpolate( $template, array $context = array())
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach (array_merge($this->defaults, $context) as $key => $val) {
          $replace['{' . $key . '}'] = is_string($val)
                                     ? $val
                                     : (is_numeric($val)
                                       ? $this->interpolateNum( $val )
                                       : ( is_null($val)
                                         ? 'NULL'
                                         : ( is_bool($val)
                                           ? ($val ? 'TRUE' : 'FALSE')
                                           : ( is_object($val)
                                             ? $this->interpolateObject( $val )
                                               # Any other: array etc.
                                             : var_dump($val, "noecho")
                                             )
                                           )
                                         )
                                        );
        }

        // interpolate replacement values into the message and return
        return strtr( $template, $replace);
    }


    /**
     * Short Alias for interpolate.
     */
    public function i( $template, array $context = array()) {
      return $this->interpolate( $template, $context);
    }


    /**
     * Returns a simple string value of the given float value,
     * using a string cast to the value (type juggling).
     *
     * Override this method in subclasses to get a more exact
     * string representation for numbers like 1.0
     *
     * @param  float|double $float Any float or double number
     * @return string
     */
    public function interpolateNum( $float )
    {
        return (string) $float;
    }


    /**
     * Returns the class name of the given object.
     *
     * Override this method in subclasses to get more
     * detailed information about the object passed,
     * e.g. an Exception object.
     *
     * @param  object $object Any object
     * @return string
     */
    public function interpolateObject( $object )
    {
        return ($object instanceOf StringProvider)
              ? $object->__toString()
              : get_class( $object );
    }

}
