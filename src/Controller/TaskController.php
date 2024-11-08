<?php

// src/Controller/TaskController.php
namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
  /**
   * @Route("/task", name="task_index")
   */
  public function index(EntityManagerInterface $em): Response
  {
    $tasks = $em->getRepository(Task::class)->findAll();

    return $this->render('task/index.html.twig', [
      'tasks' => $tasks,
    ]);
  }

  /**
   * @Route("/task/new", name="task_new")
   */
  public function new(Request $request, EntityManagerInterface $em): Response
  {
    $task = new Task();
    $form = $this->createForm(TaskType::class, $task);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($task);
      $em->flush();

      return $this->redirectToRoute('task_index');
    }

    return $this->render('task/new.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/task/edit/{id}", name="task_edit")
   */
  public function edit(int $id, TaskRepository $taskRepository, Request $request): Response
  {
    $task = $taskRepository->find($id);
    if (!$task) {
      throw $this->createNotFoundException('Task not found');
    }
    $form = $this->createForm(TaskType::class, $task);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->flush();
      return $this->redirectToRoute('task_index');
    }
    $tasks = $taskRepository->findAll();
    return $this->render('task/edit.html.twig', [
      'form' => $form->createView(),
      'tasks' => $tasks,
    ]);
  }


  /**
   * @Route("/task/delete/{id}", name="task_delete")
   */
  public function delete(int $id, TaskRepository $taskRepository, Request $request): Response
  {
    $task = $taskRepository->find($id);
    if (!$task) {
      throw $this->createNotFoundException('Задача не найдена.');
    }
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($task);
    $entityManager->flush();
    return $this->redirectToRoute('task_index');
  }
}
