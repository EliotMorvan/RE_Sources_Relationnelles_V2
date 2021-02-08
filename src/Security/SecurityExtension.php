<?php

namespace Security;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SecurityExtension extends AbstractExtension
{
    /**
     * @var Security
     */
    private $security;

    /**
     * Constructor.
     *
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getFunctions()
    {
        return [
            /** @see templates/admin/fragment/navbar.html.twig */
            new TwigFunction('get_user', [$this->security, 'getUser']),
        ];
    }
}
