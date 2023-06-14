<?php

namespace FilterObjects\Includes;

defined( 'ABSPATH' ) || exit;

class Autoloader {

	public const PREFIX = 'FilterObjects\\';

	/**
	 * Register loader.
	 *
	 * @return void
	 */
	public function register(): void {
		spl_autoload_register( [ $this, 'loadClass' ] );
	}

	/**
	 * Loads the class file for a given class name.
	 *
	 * @param string $class
	 *
	 * @return void
	 */
	public function loadClass( string $class ) {
		$baseDir       = plugin_dir_path( FILTER_OBJECTS_FILE );
		$relativeClass = $this->getRelativeClass( $class );
		$className     = $this->getClassName( $relativeClass );
		$path          = $this->convertNamespaceToPath( $className, $relativeClass );
		$file          = $baseDir . str_replace( '\\', '/', $path . $className ) . '.php';

		$this->requireFile( $file );
	}

	/**
	 * Get the relative class name by removing the prefix.
	 *
	 * @param string $class
	 *
	 * @return string
	 */
	private function getRelativeClass( string $class ): string {
		return substr( $class, strlen( self::PREFIX ) );
	}

	/**
	 * Get the class name from the path.
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	private function getClassName( string $path ): string {
		return substr( strrchr( $path, '\\' ), 1 );
	}

	/**
	 * Converts namespace with camel case to dash.
	 *
	 * @param string $className
	 * @param string $namespace
	 *
	 * @return string
	 */
	private function convertNamespaceToPath( string $className, string $namespace ): string {
		$path = str_replace( $className, '', $namespace );

		return strtolower( preg_replace( '/([a-zA-Z])(?=[A-Z])/', '$1-', $path ) );
	}

	/**
	 * If a file exists, require it from the file system.
	 *
	 * @param string $file
	 *
	 * @return void
	 */
	private function requireFile( string $file ): void {
		if ( file_exists( $file ) ) {
			require $file;
		}
	}
}