<?php

namespace AppBundle\Entity;

use DateInterval;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->startDatetime = new \DateTime('now');
        $this->endDatetime = new \DateTime('now');
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDatetime", type="datetime")
     */
    private $startDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDatetime", type="datetime")
     */
    private $endDatetime;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Action", inversedBy="periods", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startDatetime
     *
     * @param \DateTime $startDatetime
     *
     * @return Event
     */
    public function setStartDatetime($startDatetime)
    {
        $this->startDatetime = $startDatetime;

        return $this;
    }

    /**
     * Get startDatetime
     *
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * Set endDatetime
     *
     * @param \DateTime $endDatetime
     *
     * @return Event
     */
    public function setEndDatetime($endDatetime)
    {
        $this->endDatetime = $endDatetime;

        return $this;
    }

    /**
     * Get endDatetime
     *
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * Set action
     *
     * @param \AppBundle\Entity\Action $action
     * @return Event
     */
    public function setAction(Action $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \AppBundle\Entity\Action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Get status
     *
     */
    public function getStatus()
    {
        $now = new \DateTime('now');
        $now->add(new DateInterval('PT9H'));

        $start = $this->startDatetime;
        $end = $this->endDatetime;

        if ($now > $end) {
            return 'CompletedAction';
        } elseif ($now >= $start && $now <= $end) {
            return 'ActiveAction';
        } elseif ($now < $start) {
            return 'PotentialAction';
        }
    }

    /**
     * Get a label for the DateInterval
     *
     */
    public function getIntervalLabel()
    {
        $start = $this->startDatetime->format('U');
        $end = $this->endDatetime->format('U');

        $startDay = date('d', $start);
        $startMonth = date('F', $start);
        $startYear = date('Y', $start);

        $endDay = date('d', $end);
        $endMonth = date('F', $end);
        $endYear = date('Y', $end);

        //For different years
        if ($startYear < $endYear) {
            $label = "Du " . $startDay . "/" . $startMonth . "/" . $startYear . " au " . $endDay . "/" . $endMonth . "/" . $endYear;
        } elseif ($startMonth < $endMonth) {
            // For different months years
            $label = "Du " . $startDay . " " . $startMonth . " au " . $endDay . " " . $endMonth . " " . $endYear;
        } elseif ($startDay < $endDay) {
            // For different days
            $label = "Du " . $startDay . " au " . $endDay . " " . $endMonth . " " . $endYear;
        } else {
            $label = "Le " . $startDay . " " . $startMonth . " " . $startYear;
        }

        $english = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

        $label = str_replace($english, $french, $label);

        return $label;
    }

    /**
     * Get duration
     *
     */
    public function getDuration()
    {
        $diff = $this->endDatetime->diff($this->startDatetime);

        return $diff;
    }

    /**
     * Get working duration
     *
     */
    public function getWorkingDuration()
    {
        // Define beginning and end of a regular working day
        $dayStart = 6;
        $dayEnd = 18;

        // If more than a day, calculate approximate duration time
        if($this->getDuration()> new DateInterval("PT24H")){
        $start = $this->startDatetime;
        $end = $this->endDatetime;
        $oneHour = new DateInterval('PT1H');

        $hours = 0;

        /* Iterate from $start up to $end+1 hour, one hour in each iteration.
           We add one hour to the $end date, because the DatePeriod only iterates up to,
           not including, the end date. */
        foreach (new \DatePeriod($start, $oneHour, $end->add($oneHour)) as $hour) {
            $hour_num = $hour->format("H");
            if ($hour_num > $dayStart && $hour_num < $dayEnd) {
                $hours++;
            }
        }
        return $hours.'h';
        }else{
            // If less than a day calculate exact duration
            return $this->format_duration($this->getDuration());
        }
    }

    /**
     * Get duration label
     *
     */
    public function getDurationLabel()
    {
        $label = $this->getWorkingDuration();

        return $label;
    }

    /**
     * Format an interval to show all existing components.
     * If the interval doesn't have a time component (years, months, etc)
     * That component won't be displayed.
     *
     * @param DateInterval $interval The interval
     *
     * @return string Formatted interval string.
     */
    function format_duration(DateInterval $interval)
    {
        $result = "";

        // Years
        if ($interval->y) {
            if ($interval->y == 1) {
                $result .= $interval->format("%y an ");
            } else {
                $result .= $interval->format("%y ans ");
            }
        }

        // Months
        if ($interval->m) {
            $result .= $interval->format("%m mois ");
        }

        // Days
        if ($interval->d) {

            if ($interval->d == 1) {
                $result .= $interval->format("%d jour ");
            } else {
                $result .= $interval->format("%d jours ");
            }
        }

        // Hours
        if ($interval->h) {
            $result .= $interval->format("%hh");
        }

        // Minutes
        if ($interval->i) {
            $result .= $interval->format("%im ");
        }

        return $result;
    }


}

