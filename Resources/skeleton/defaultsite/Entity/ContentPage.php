<?php

namespace {{ namespace }}\Entity;

use Doctrine\ORM\Mapping as ORM;

use {{ namespace }}\Entity\AbstractContentPage;

/**
 * ContentPage
 *
 * @ORM\Entity()
 * @ORM\Table(name="{{ prefix }}content_pages")
 */
class ContentPage extends AbstractContentPage
{

}