<?php

namespace App\Interfaces;

interface EventParticipantRepositoryInterface
{
    public function getAllEventParticipants(string|null $search, int|null $limit, bool $execute);

    public function getAllPaginated(string|null $search, int|null $rowPerPage);

    public function create(array $data);

    public function getById(string $id);

    public function update(array $data, string $id);

    public function delete(string $id);
}
