<?php

namespace B13\Container\Tests\Functional\Frontend;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;

class LanguageFallbackTest extends AbstractFrontendTest
{

    /**
     * @test
     */
    public function nothingTranslated(): void
    {
        $response = $this->executeFrontendRequest(new InternalRequest('/fr'));
        $body = (string)$response->getBody();
        $body = $this->prepareContent($body);
        $this->assertStringContainsString('<h1 class="container">container-default</h1>', $body);
        $this->assertStringNotContainsString('<h1 class="container">container-fr</h1>', $body);
        $this->assertStringContainsString('<h6 class="header-childs">header-default</h6>', $body);
        $this->assertStringNotContainsString('<h6 class="header-childs">header-fr</h6>', $body);
        // rendered content
        $this->assertStringNotContainsString('<h2 class="">header-fr</h2>', $body);
        $this->assertStringContainsString('<h2 class="">header-default</h2>', $body);
    }

    /**
     * @test
     */
    public function bothTranslated(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Fixtures/LanguageFallback/tt_content_both_translated.xml');
        $response = $this->executeFrontendRequest(new InternalRequest('/fr'));
        $body = (string)$response->getBody();
        $body = $this->prepareContent($body);
        $this->assertStringContainsString('<h1 class="container">container-fr</h1>', $body);
        $this->assertStringNotContainsString('<h1 class="container">container-default</h1>', $body);
        $this->assertStringContainsString('<h6 class="header-childs">header-fr</h6>', $body);
        $this->assertStringNotContainsString('<h6 class="header-childs">header-default</h6>', $body);
        // rendered content
        $this->assertStringContainsString('<h2 class="">header-fr</h2>', $body);
        $this->assertStringNotContainsString('<h2 class="">header-default</h2>', $body);
    }

    /**
     * @test
     */
    public function childTranslated(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Fixtures/LanguageFallback/tt_content_child_translated.xml');
        $response = $this->executeFrontendRequest(new InternalRequest('/fr'));
        $body = (string)$response->getBody();
        $body = $this->prepareContent($body);
        $this->assertStringContainsString('<h1 class="container">container-default</h1>', $body);
        $this->assertStringNotContainsString('<h1 class="container">container-fr</h1>', $body);
        $this->assertStringContainsString('<h6 class="header-childs">header-fr</h6>', $body);
        $this->assertStringNotContainsString('<h6 class="header-childs">header-default</h6>', $body);
        // rendered content
        $this->assertStringContainsString('<h2 class="">header-fr</h2>', $body);
        $this->assertStringNotContainsString('<h2 class="">header-default</h2>', $body);
    }

    /**
     * @test
     */
    public function containerTranslated(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Fixtures/LanguageFallback/tt_content_container_translated.xml');
        $response = $this->executeFrontendRequest(new InternalRequest('/fr'));
        $body = (string)$response->getBody();
        $body = $this->prepareContent($body);
        $this->assertStringContainsString('<h1 class="container">container-fr</h1>', $body);
        $this->assertStringNotContainsString('<h1 class="container">container-default</h1>', $body);
        $this->assertStringContainsString('<h6 class="header-childs">header-default</h6>', $body);
        $this->assertStringNotContainsString('<h6 class="header-childs">header-fr</h6>', $body);
        // rendered content
        $this->assertStringNotContainsString('<h2 class="">header-fr</h2>', $body);
        $this->assertStringContainsString('<h2 class="">header-default</h2>', $body);
    }
}
