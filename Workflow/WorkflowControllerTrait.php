<?php
namespace CoreBundle\Workflow;

use FreeAgent\WorkflowBundle\Exception\WorkflowException;
use FreeAgent\WorkflowBundle\Manager\Manager;
use FreeAgent\WorkflowBundle\Model\ModelInterface;

trait WorkflowControllerTrait
{
    /**
     * Adds a flash message to the current session for type.
     *
     * @param string $type    The type
     * @param string $message The message
     *
     * @throws \LogicException
     */
    abstract protected function addFlash($type, $message);

    /**
     * @param string      $id         The message id (may also be an object that can be cast to string)
     * @param array       $parameters An array of parameters for the message
     * @param string|null $domain     The domain for the message or null to use the default
     * @param string|null $locale     The locale or null to use the default
     *
     * @throws \InvalidArgumentException If the locale contains invalid characters
     *
     * @return string The translated string
     */
    abstract protected function trans($id, array $parameters = array(), $domain = null, $locale = null);

    /**
     * @param ModelInterface $model
     * @param string $stepName
     *
     * @return array
     */
    protected function reachStep($model, $stepName)
    {
        $manager = $this->getWorkflowManager();

        $manager->setModel($model);

        if (!$manager->canReachStep($stepName)) {
            if (count($manager->getValidationErrors($stepName))) {
                foreach ($manager->getValidationErrors($stepName) as $errorMessage) {
                    if ($errorMessage) {
                        $this->addFlash('danger', $errorMessage);
                    }
                }
            } else if ($stepName != $manager->getCurrentStepName()) {
                $this->addFlash(
                    'danger',
                    $this->trans(
                        'workflow.message.error.impossible_to_reach_step',
                        array(
                            '%status_name%' => $stepName,
                            '%current_status_name%' => $manager->getCurrentStepName()
                        )
                    )
                );
            }

            return $manager->getValidationErrors($stepName);
        }

        $manager->reachStep($stepName);
    }

    /**
     * @param ModelInterface $model
     * @param string $stepName
     *
     * @return mixed
     */
    public function checkStep($model, $stepName)
    {
        $manager = $this->getWorkflowManager();

        $manager->setModel($model);

        return $manager->canReachStep($stepName);
    }

    /**
     * @return Manager
     */
    public function getWorkflowManager()
    {
        return $this->get('free_agent_workflow.manager');
    }
}
