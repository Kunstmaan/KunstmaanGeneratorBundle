<?php

namespace {{ namespace }}\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\MediaBundle\Entity\Media;

{% if canUseEntityAttributes %}
#[ORM\Entity]
#[ORM\Table(name: '{{ prefix }}{{ underscoreName }}s')]
{% else %}
/**
 * @ORM\Entity
 * @ORM\Table(name="{{ prefix }}{{ underscoreName }}s")
 */
{% endif %}
class {{ pagepart }} extends AbstractPagePart
{
    /**
     * @var Media|null
{% if canUseEntityAttributes == false %}
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
{% endif %}
     */
{% if canUseEntityAttributes %}
    #[ORM\ManyToOne(targetEntity: Media::class)]
{% endif %}
    protected $media;

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): AudioPagePart
    {
        $this->media = $media;

        return $this;
    }

    public function getDefaultView(): string
    {
        return '{% if not isV4 %}{{ bundle }}:{%endif%}PageParts/{{ pagepart }}{% if not isV4 %}:{% else %}/{% endif %}view.html.twig';
    }

    public function getDefaultAdminType(): string
    {
        return {{ adminType }}::class;
    }
}
