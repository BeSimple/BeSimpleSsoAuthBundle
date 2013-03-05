<?php

namespace BeSimple\SsoAuthBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DomCrawler\Crawler;
use BeSimple\SsoAuthBundle\Tests\AppKernel;
use BeSimple\SsoAuthBundle\Tests\HttpClient;

/**
 * @method assertEquals
 */
abstract class WebTestCase extends BaseWebTestCase
{
    static protected $tmpPath;
    static protected $configFile;

    const LOGIN_USER    = 'user';
    const LOGIN_ADMIN   = 'admin';
    const LOGIN_INVALID = 'invalid';

    public function provideClients()
    {
        return array(
            array('cas')
        );
    }

    protected function createSsoClient($name)
    {
        return static::createClient(array('sso_server_name' => $name));
    }

    protected function getXml(Crawler $crawler)
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $crawler->each(function(\DOMElement $node) use ($document) {
            $document->appendChild($document->importNode($node, true));
        });
        return html_entity_decode($document->saveXML());
    }

    static protected function createKernel(array $options = array())
    {
        static::$tmpPath    = sys_get_temp_dir().'/be_simple_sso_auth_bundle_tests';
        static::$configFile = __DIR__.'/../Resources/config/'.$options['sso_server_name'].'.yml';

        if (file_exists(static::$tmpPath)) {
            $fs = new Filesystem();
            $fs->remove(static::$tmpPath);
        }

        $kernel = new AppKernel(
            static::$tmpPath,
            static::$configFile,
            isset($options['environment']) ? $options['environment'] : 'test',
            isset($options['debug']) ? $options['debug'] : true
        );

        HttpClient::setKernel($kernel);

        return $kernel;
    }

    /**
     * Shuts the kernel down if it was used in the test
     * and remove temp files.
     */
    protected function tearDown()
    {
        if (null !== static::$kernel) {
            static::$kernel->shutdown();

            $fs = new Filesystem();
            $fs->remove(static::$tmpPath);
        }
    }
}
