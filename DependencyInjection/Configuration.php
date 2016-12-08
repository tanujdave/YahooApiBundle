<?php

namespace YahooApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface {
	/**
	 * {@inheritdoc}
	 */
	public function getConfigTreeBuilder() {
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root( 'yahoo_api' );
		$rootNode
			->children()
			->scalarNode( 'application_id' )->isRequired()->cannotBeEmpty()->end()
			->scalarNode( 'consumer_key' )->isRequired()->cannotBeEmpty()->end()
			->scalarNode( 'consumer_secret' )->isRequired()->cannotBeEmpty()->end()
			->scalarNode( 'callback_url' )->isRequired()->cannotBeEmpty()->end()
			->end();
		return $treeBuilder;
	}
}
