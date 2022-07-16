<?php

	namespace OOPCRE\Foundation;

	use OOPCRE\Foundation\Definition\Option;

	/**
	 * Configurator class.
	 */
	class Configurator {

		/**
		 * Holds the current configuration.
		 *
		 * @var array $config
		 */
		private array $config;

		/**
		 * Set up the default configurations.
		 *
		 */
		public function __construct() {
			$this->config = Option::configMap();
		}

		/**
		 * Get the value of a given config key. Alias for get() method.
		 *
		 * @param \OOPCRE\Foundation\Definition\Option $option A case from the Option enum.
		 *
		 * @return mixed
		 */
		public function getConfig( Option $option ): mixed {
			return $this->get( $option );
		}

		/**
		 * Set a config using the given value. Alias for set() method.
		 *
		 * @param \OOPCRE\Foundation\Definition\Option $option A case from the Option enum.
		 * @param mixed|NULL                           $value  The value for the current config to be set.
		 *
		 * @return $this
		 */
		public function setConfig( Option $option, mixed $value = NULL ): self {
			return $this->set( $option, $value );
		}

		/**
		 * Get the value of a current config.
		 *
		 * @param \OOPCRE\Foundation\Definition\Option $name A case from the Option enum.
		 *
		 * @return mixed
		 */
		public function get( Option $name ): mixed {
			// If the config is not set, return the default value
			return $this->config[ $name->value ] ?? $name->value;
		}

		/**
		 * Set a single config.
		 *
		 * @param \OOPCRE\Foundation\Definition\Option $option A case from the Option enum.
		 * @param mixed                                $value  The value for the current config to be set.
		 *
		 * @return \OOPCRE\Foundation\Configurator
		 */
		public function set( Option $option, mixed $value = NULL ): self {
			// Case the config into an array.
			$this->config[ $option->value ] = $value;
			return $this;
		}
	}