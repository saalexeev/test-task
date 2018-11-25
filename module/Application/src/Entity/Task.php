<?php
/**
 * Created by PhpStorm.
 * User: Stanislav
 * Date: 24.11.2018
 * Time: 18:26
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task
 *
 * @package Application\Entity
 * @ORM\Table(name="task")
 * @ORM\Entity
 */
class Task {

    /**
     * @var int $id
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string $title
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private $title;

    /**
     * @var \DateTime $date
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string $author
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private $author;

    /**
     * @var string $status
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private $status;

    /**
     * @var string $description
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private $description;

    /**
     * @param int $id
     */
    public function setId (int $id) {
        $this->id = $id;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate (\DateTime $date) {
        $this->date = $date;
    }

    /**
     * @param string $title
     */
    public function setTitle (string $title) {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getId (): ?int {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate (): ?\DateTime {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getTitle (): ?string {
        return $this->title;
    }

    /**
     * @param string $author
     */
    public function setAuthor (string $author) {
        $this->author = $author;
    }

    /**
     * @param string $status
     */
    public function setStatus (string $status) {
        $this->status = $status;
    }

    /**
     * @param string $description
     */
    public function setDescription (string $description) {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getAuthor (): ?string {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getDescription (): ?string {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getStatus (): ?string {
        return $this->status;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize () {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date->format('d.m.Y H:i:s'),
            'author' => $this->author,
            'status' => $this->status,
            'description' => $this->description
        ];
    }
}