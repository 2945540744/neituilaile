<?php

namespace Neitui\Service;

interface JobService
{
    public function getJob($id);

    public function searchJobs();

    public function findJobs($userId);

    public function createJob($job, $userId);

    public function updateJob($job, $userId);

    public function deleteJob($jobId, $userId);

    public function closeJob($jobId, $userId);

    public function getFavorites($userId);

    public function isFavorited($jobId, $userId);

    public function addFavorite($jobId, $userId);

    public function removeFavorite($jobId, $userId);
}
