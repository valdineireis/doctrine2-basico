<?php

namespace App\Entity;

/**
 * @Entity
 * @Table(name="posts")
 */
class Post
{
	/**
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @Column(type="string", length=100)
	 */
	private $titulo;

	/**
	 * @Column(type="text")
	 */
	private $conteudo;

	public function getId()
	{
		return $this->id;
	}

	public function getTitulo()
	{
		return $this->titulo;
	}

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
		return $this;
	}

	public function getConteudo()
	{
		return $this->conteudo;
	}

	public function setConteudo($conteudo)
	{
		$this->conteudo = $conteudo;
		return $this;
	}
}
