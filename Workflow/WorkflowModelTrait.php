<?php
namespace CoreBundle\Workflow;

/**
 * To use this trait fields 'workflowName' and 'status' must be defined in your model.
 */
trait WorkflowModelTrait
{
    /**
     * @var int
     */
    protected $stepAt;

    /**
     * @var string
     */
    protected $stepComment;

    public function getWorkflowName()
    {
        return $this->workflowName;
    }

    public function setWorkflowName($workflowName)
    {
        $this->workflowName = $workflowName;
    }

    /**
     * @return string
     */
    public function getWorkflowStepName()
    {
        return $this->status;
    }

    /**
     * @param string $stepName
     */
    public function setWorkflowStepName($stepName)
    {
        $this->status = $stepName;
    }

    /**
     * Gets comment
     *
     * @return string
     */
    public function getWorkflowStepComment()
    {
        return $this->stepComment;
    }

    /**
     * Sets
     *
     * @param string $comment
     *
     * @return WorkflowModelTrait
     */
    public function setWorkflowStepComment($comment)
    {
        $this->stepComment = $comment;

        return $this;
    }

    /**
     * Gets stepAt
     *
     * @return int
     */
    public function getWorkflowStepAt()
    {
        return $this->stepAt;
    }

    /**
     * Sets
     *
     * @param int $stepAt
     *
     * @return WorkflowModelTrait
     */
    public function setWorkflowStepAt($stepAt)
    {
        $this->stepAt = $stepAt;

        return $this;
    }
}
