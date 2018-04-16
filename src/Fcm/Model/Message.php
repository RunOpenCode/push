<?php

namespace RunOpenCode\Push\Fcm\Model;

use Ramsey\Uuid\Uuid;
use RunOpenCode\Push\Fcm\Contract\MessageInterface;
use RunOpenCode\Push\Fcm\Enum\Priority;

class Message implements MessageInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $registrationIds;

    /**
     * @var null|string
     */
    private $title;

    /**
     * @var null|string
     */
    private $body;

    /**
     * @var null|string
     */
    private $androidChannelId;

    /**
     * @var null|array
     */
    private $data;

    /**
     * @var null|bool
     */
    private $vibrate;

    /**
     * @var null|string
     */
    private $sound;

    /**
     * @var null|string
     */
    private $icon;

    /**
     * @var null|string
     */
    private $tag;

    /**
     * @var null|string
     */
    private $color;

    /**
     * @var null|string
     */
    private $collapseKey;

    /**
     * @var null|int
     */
    private $timeToLive;

    /**
     * @var null|string
     */
    private $restrictedPackageName;

    /**
     * @var null|bool
     */
    private $dryRun;

    /**
     * @var null|string
     */
    private $priority;

    /**
     * @var null|string
     */
    private $condition;

    /**
     * @var null|bool
     */
    private $contentAvailable;

    /**
     * @var null|int
     */
    private $badge;

    /**
     * @var string|null
     */
    private $clickAction;

    /**
     * @var string|null
     */
    private $bodyLocKey;

    /**
     * @var array|null
     */
    private $bodyLocArgs;

    /**
     * @var string|null
     */
    private $titleLocKey;

    /**
     * @var array|null
     */
    private $titleLocArgs;

    /**
     * @var int
     */
    private $sendCount;

    public function __construct(
        ?string $id = null,
        array $registrationIds,
        ?string $title = null,
        ?string $body = null,
        ?string $androidChannelId = null,
        ?array $data = null,
        ?bool $vibrate = null,
        ?string $sound = null,
        ?string $icon = null,
        ?string $tag = null,
        ?string $color = null,
        ?string $collapseKey = null,
        ?int $timeToLive = null,
        ?string $restrictedPackageName = null,
        ?bool $dryRun = null,
        string $priority = Priority::NORMAL,
        ?string $condition = null,
        ?bool $contentAvailable = null,
        ?int $badge = null,
        ?string $clickAction = null,
        ?string $bodyLocKey = null,
        ?array $bodyLocArgs = null,
        ?string $titleLocKey = null,
        ?array $titleLocArgs = null,
        int $sendCount = 0
    )
    {
        $this->setId($id);
        $this->setRegistrationIds($registrationIds);
        $this->setTitle($title);
        $this->setBody($body);
        $this->setAndroidChannelId($androidChannelId);
        $this->setData($data);
        $this->setVibrate($vibrate);
        $this->setSound($sound);
        $this->setIcon($icon);
        $this->setTag($tag);
        $this->setColor($color);
        $this->setCollapseKey($collapseKey);
        $this->setTimeToLive($timeToLive);
        $this->setRestrictedPackageName($restrictedPackageName);
        $this->setDryRun($dryRun);
        $this->setPriority($priority);
        $this->setCondition($condition);
        $this->setContentAvailable($contentAvailable);
        $this->setBadge($badge);
        $this->setClickAction($clickAction);
        $this->setBodyLocKey($bodyLocKey);
        $this->setBodyLocArgs($bodyLocArgs);
        $this->setTitleLocKey($titleLocKey);
        $this->setTitleLocArgs($titleLocArgs);
        $this->setSendCount($sendCount);
    }

    /**
     * @return null|string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getRegistrationIds(): array
    {
        return $this->registrationIds;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return null|string
     */
    public function getAndroidChannelId(): ?string
    {
        return $this->androidChannelId;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @return bool|null
     */
    public function getVibrate(): ?bool
    {
        return $this->vibrate;
    }

    /**
     * @return null|string
     */
    public function getSound(): ?string
    {
        return $this->sound;
    }

    /**
     * @return null|string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @return null|string
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @return null|string
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @return null|string
     */
    public function getCollapseKey(): ?string
    {
        return $this->collapseKey;
    }

    /**
     * @return int|null
     */
    public function getTimeToLive(): ?int
    {
        return $this->timeToLive;
    }

    /**
     * @return null|string
     */
    public function getRestrictedPackageName(): ?string
    {
        return $this->restrictedPackageName;
    }

    /**
     * @return bool|null
     */
    public function getDryRun(): ?bool
    {
        return $this->dryRun;
    }

    /**
     * @return null|string
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }

    /**
     * @return null|string
     */
    public function getCondition(): ?string
    {
        return $this->condition;
    }

    /**
     * @return bool|null
     */
    public function getContentAvailable(): ?bool
    {
        return $this->contentAvailable;
    }

    /**
     * @return int|null
     */
    public function getBadge(): ?int
    {
        return $this->badge;
    }

    /**
     * @return null|string
     */
    public function getClickAction(): ?string
    {
        return $this->clickAction;
    }

    /**
     * @return null|string
     */
    public function getBodyLocKey(): ?string
    {
        return $this->bodyLocKey;
    }

    /**
     * @return array|null
     */
    public function getBodyLocArgs(): ?array
    {
        return $this->bodyLocArgs;
    }

    /**
     * @return null|string
     */
    public function getTitleLocKey(): ?string
    {
        return $this->titleLocKey;
    }

    /**
     * @return array|null
     */
    public function getTitleLocArgs(): ?array
    {
        return $this->titleLocArgs;
    }

    /**
     * @return int
     */
    public function getSendCount(): int
    {
        return $this->sendCount;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id'                    => $this->id,
            'registrationIds'       => $this->registrationIds,
            'title'                 => $this->title,
            'body'                  => $this->body,
            'data'                  => $this->data,
            'vibrate'               => $this->vibrate,
            'sound'                 => $this->sound,
            'icon'                  => $this->icon,
            'tag'                   => $this->tag,
            'color'                 => $this->color,
            'collapseKey'           => $this->collapseKey,
            'timeToLive'            => $this->timeToLive,
            'restrictedPackageName' => $this->restrictedPackageName,
            'dryRun'                => $this->dryRun,
            'priority'              => $this->priority,
            'condition'             => $this->condition,
            'contentAvailable'      => $this->contentAvailable,
            'badge'                 => $this->badge,
            'clickAction'           => $this->clickAction,
            'bodyLocKey'            => $this->bodyLocKey,
            'bodyLocArgs'           => $this->bodyLocArgs,
            'titleLocKey'           => $this->titleLocKey,
            'titleLocArgs'          => $this->titleLocArgs,
            'sendCount'             => $this->sendCount,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $data)
    {
        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * @return Message $this
     *
     * @throws \InvalidArgumentException
     */
    private function setId(?string $id = null): Message
    {
        if (null === $id) {
            $id = Uuid::uuid4()->toString();
        }

        if (!preg_match('/^[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}$/i', $id)) {
            throw new \InvalidArgumentException('Identifier must be null OR a valid guid.');
        }

        $this->id = $id;

        return $this;
    }

    /**
     * @param array $registrationIds
     *
     * @return Message
     *
     * @throws \InvalidArgumentException
     */
    public function setRegistrationIds(array $registrationIds): Message
    {
        foreach ($registrationIds as $registrationId) {

            if (!trim($registrationId)) {
                throw new \InvalidArgumentException('Empty registration ID provided in collection of registration IDs.');
            }
        }

        $this->registrationIds = $registrationIds;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return Message
     */
    public function setTitle(?string $title): Message
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $body
     *
     * @return Message
     */
    public function setBody(?string $body): Message
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param null|string $channel
     *
     * @return Message
     */
    public function setAndroidChannelId(?string $channel): Message
    {
        $this->androidChannelId = $channel;

        return $this;
    }

    /**
     * @param array|null $data
     *
     * @return Message
     */
    public function setData(?array $data): Message
    {
        $this->data = count($data) ? $data : null;

        return $this;
    }

    /**
     * @param boolean $vibrate
     *
     * @return Message
     */
    public function setVibrate(?bool $vibrate): Message
    {
        $this->vibrate = $vibrate;

        return $this;
    }

    /**
     * @param string $sound
     *
     * @return Message
     */
    public function setSound(?string $sound): Message
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @param string $icon
     *
     * @return Message
     */
    public function setIcon(?string $icon): Message
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param string $tag
     *
     * @return Message
     */
    public function setTag(?string $tag): Message
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @param string $color
     *
     * @return Message
     */
    public function setColor(?string $color): Message
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param string $collapseKey
     *
     * @return Message
     */
    public function setCollapseKey(?string $collapseKey): Message
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * @param int $timeToLive
     *
     * @return Message
     *
     * @throws \InvalidArgumentException
     */
    public function setTimeToLive(?int $timeToLive): Message
    {
        if (is_int($timeToLive) && !($timeToLive >= 0 && $timeToLive <= 2419200)) {
            throw new \InvalidArgumentException('Time to live can be between 0 and 2.419.200 seconds (4 weeks).');
        }

        $this->timeToLive = $timeToLive;

        return $this;
    }

    /**
     * @param string $restrictedPackageName
     *
     * @return Message
     */
    public function setRestrictedPackageName(?string $restrictedPackageName): Message
    {
        $this->restrictedPackageName = $restrictedPackageName;

        return $this;
    }

    /**
     * @param boolean $dryRun
     *
     * @return Message
     */
    public function setDryRun(?bool $dryRun): Message
    {
        $this->dryRun = $dryRun;

        return $this;
    }

    /**
     * @param string $priority
     *
     * @return Message
     *
     * @throws \InvalidArgumentException
     */
    public function setPriority(string $priority): Message
    {
        if (!in_array($priority, [Priority::HIGH, Priority::NORMAL], true)) {

            throw new \InvalidArgumentException(sprintf(
                'Invalid priority value given, allowed values are "%s" or "%s".',
                Priority::NORMAL,
                Priority::HIGH
            ));
        }

        $this->priority = $priority;

        return $this;
    }

    /**
     * @param string $condition
     *
     * @return Message
     */
    public function setCondition(?string $condition): Message
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @param bool $contentAvailable
     *
     * @return Message $this
     */
    private function setContentAvailable(?bool $contentAvailable): Message
    {
        $this->contentAvailable = $contentAvailable;

        return $this;
    }

    /**
     * @param int|null $badge
     *
     * @return Message $this
     *
     * @throws \InvalidArgumentException
     */
    private function setBadge(?int $badge): Message
    {
        if (null !== $badge && $badge < 0) {
            throw new \InvalidArgumentException('Badge must be positive number or zero.');
        }

        $this->badge = $badge;

        return $this;
    }

    /**
     * @param null|string $key
     *
     * @return Message $this
     */
    private function setClickAction(?string $key): Message
    {
        $this->clickAction = $key;

        return $this;
    }

    /**
     * @param string|null $key
     *
     * @return Message $this
     */
    private function setBodyLocKey(?string $key): Message
    {
        $this->bodyLocKey = $key;

        return $this;
    }

    /**
     * @param array|null $args
     *
     * @return Message $this
     *
     * @throws \InvalidArgumentException
     */
    private function setBodyLocArgs(?array $args): Message
    {
        if (is_array($args)) {

            foreach ($args as $a) {

                if (!is_scalar($a)) {
                    throw new \InvalidArgumentException('Arguments must only contain scalar values.');
                }
            }
        }

        $this->bodyLocArgs = $args;

        return $this;
    }

    /**
     * @param string|null $key
     *
     * @return Message $this
     */
    private function setTitleLocKey(?string $key): Message
    {
        $this->titleLocKey = $key;

        return $this;
    }

    /**
     * @param array|null $args
     *
     * @return Message $this
     *
     * @throws \InvalidArgumentException
     */
    private function setTitleLocArgs(?array $args): Message
    {
        if (is_array($args)) {

            foreach ($args as $a) {

                if (!is_scalar($a)) {
                    throw new \InvalidArgumentException('Title Arguments must only contain scalar values');
                }
            }
        }

        $this->titleLocArgs = $args;

        return $this;
    }

    /**
     * @param $sendCount
     *
     * @return Message $this
     *
     * @throws \InvalidArgumentException
     */
    private function setSendCount(int $sendCount): Message
    {
        if ($sendCount < 0) {
            throw new \InvalidArgumentException('Send count must be greater then zero (0)');
        }

        $this->sendCount = $sendCount;

        return $this;
    }
}