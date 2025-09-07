<?php

namespace App\Interfaces;

interface HeadOfFamilyRepositoryInterface
{
    public function getAllHeadOfFamilies(
        ?string $search,
        ?int $limit,
        bool $execute
    );

    public function getAllPaginated(
        ?string $search,
        ?int $rowPerPage
    );

    public function create(array $data);

    public function getById(string $id);

    public function update(array $data, string $id);

    public function delete(string $id);
}
