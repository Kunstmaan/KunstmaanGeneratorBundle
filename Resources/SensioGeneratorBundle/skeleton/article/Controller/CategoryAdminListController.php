<?php

namespace {{ namespace }}\Controller;

use {{ namespace }}\AdminList\{{ entity_class }}CategoryAdminListConfigurator;
use Kunstmaan\ArticleBundle\Controller\AbstractArticleCategoryAdminListController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
{% if isV4 %}

{% if canUseAttributes %}
#[Route('/{_locale}/%kunstmaan_admin.admin_prefix%/{{ entity_class|lower}}-category', requirements: ['_locale' => '%requiredlocales%'])]
{% else %}
/**
 * @Route("/{_locale}/%kunstmaan_admin.admin_prefix%/{{ entity_class|lower}}-category", requirements={"_locale"="%requiredlocales%"})
 */
{% endif %}
{% endif %}
class {{ entity_class }}CategoryAdminListController extends AbstractArticleCategoryAdminListController
{
{% if canUseAttributes %}
    #[Route('/', name: '{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category')]
{% else %}
    /**
     * @Route("/", name="{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category")
     */
{% endif %}
    public function indexAction(Request $request): Response
    {
        return parent::doIndexAction($this->getAdminListConfigurator($request), $request);
    }

{% if canUseAttributes %}
    #[Route('/add', name: '{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_add', methods: ['GET', 'POST'])]
{% else %}
    /**
     * @Route("/add", name="{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_add", methods={"GET", "POST"})
     */
{% endif %}
    public function addAction(Request $request): Response
    {
        return parent::doAddAction($this->getAdminListConfigurator($request), null, $request);
    }

{% if canUseAttributes %}
    #[Route('/{id}', requirements: ['id' => '\d+'], name: '{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_edit', methods: ['GET', 'POST'])]
{% else %}
    /**
     * @Route("/{id}", requirements={"id" = "\d+"}, name="{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_edit", methods={"GET", "POST"})
     */
{% endif %}
    public function editAction(Request $request, int $id): Response
    {
        return parent::doEditAction($this->getAdminListConfigurator($request), $id, $request);
    }

{% if canUseAttributes %}
    #[Route('/{id}/view', requirements: ['id' => '\d+'], name: '{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_view', methods: ['GET'])]
{% else %}
    /**
     * @Route("/{id}/view", requirements={"id" = "\d+"}, name="{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_view", methods={"GET"})
     */
{% endif %}
    public function viewAction(Request $request, int $id): Response
    {
        return parent::doViewAction($this->getAdminListConfigurator($request), $id, $request);
    }

{% if canUseAttributes %}
    #[Route('/{id}/delete', requirements: ['id' => '\d+'], name: '{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_delete', methods: ['GET', 'POST'])]
{% else %}
    /**
     * @Route("/{id}/delete", requirements={"id" = "\d+"}, name="{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_delete", methods={"GET", "POST"})
     */
{% endif %}
    public function deleteAction(Request $request, int $id): Response
    {
        return parent::doDeleteAction($this->getAdminListConfigurator($request), $id, $request);
    }

{% if canUseAttributes %}
    #[Route('/export.{_format}', requirements: ['_format' => 'csv|xlsx|ods'], name: '{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_export', methods: ['GET', 'POST'])]
{% else %}
    /**
     * @Route("/export.{_format}", requirements={"_format" = "csv|xlsx|ods"}, name="{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_export", methods={"GET", "POST"})
     */
{% endif %}
    public function exportAction(Request $request, string $_format): Response
    {
        return parent::doExportAction($this->getAdminListConfigurator($request), $_format, $request);
    }

{% if canUseAttributes %}
    #[Route('/{id}/move-up', requirements: ['id' => '\d+'], name: '{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_move_up', methods: ['GET'])]
{% else %}
    /**
     * @Route("/{id}/move-up", requirements={"id" = "\d+"}, name="{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_move_up", methods={"GET"})
     */
{% endif %}
    public function moveUpAction(Request $request, int $id): Response
    {
        return parent::doMoveUpAction($this->getAdminListConfigurator($request), $id, $request);
    }

{% if canUseAttributes %}
    #[Route('/{id}/move-down', requirements: ['id' => '\d+'], name: '{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_move_down', methods: ['GET'])]
{% else %}
    /**
     * @Route("/{id}/move-down", requirements={"id" = "\d+"}, name="{{ bundle.getName()|lower }}_admin_{{ entity_class|lower }}category_move_down", methods={"GET"})
     */
{% endif %}
    public function moveDownAction(Request $request, int $id): Response
    {
        return parent::doMoveDownAction($this->getAdminListConfigurator($request), $id, $request);
    }

    public function createAdminListConfigurator(): {{ entity_class }}CategoryAdminListConfigurator
    {
        return new {{ entity_class }}CategoryAdminListConfigurator($this->em, $this->aclHelper);
    }
}
