<?php

namespace App\DTOs\Task;

use App\DTOs\BaseDTO;

class UpdateTaskDTO extends BaseDTO
{
    public function __construct(
        public ?int $assigned_to = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $due_date = null,
        public ?string $status = null
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'assigned_to' => $this->assigned_to,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'status' => $this->status,
        ], fn ($value) => !is_null($value));
    }
}
