<?php
/**
 * Created by IntelliJ IDEA.
 * User: salzaidy
 * Date: 2/9/18
 * Time: 5:00 PM
 */


class Order
{
    private $orderId;
    private $userId;
    private $vehicleId;
    private $orderDate;
    private $startLatitude;
    private $startLongitude;
    private $endLatitude;
    private $endLongitude;

    /**
     * Order constructor.
     * @param $orderId
     * @param $userId
     * @param $vehicleId
     * @param $orderDate
     * @param $startLatitude
     * @param $startLongitude
     * @param $endLatitude
     * @param $endLongitude
     */
    public function __construct(int $orderId, int $userId, int $vehicleId, string $orderDate,
                                float $startLatitude, float $startLongitude, float $endLatitude, float $endLongitude)
    {
        $this->orderId = $orderId;
        $this->userId = $userId;
        $this->vehicleId = $vehicleId;
        $this->orderDate = $orderDate;
        $this->startLatitude = $startLatitude;
        $this->startLongitude = $startLongitude;
        $this->endLatitude = $endLatitude;
        $this->endLongitude = $endLongitude;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getVehicleId(): int
    {
        return $this->vehicleId;
    }

    /**
     * @param int $vehicleId
     */
    public function setVehicleId(int $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }

    /**
     * @return string
     */
    public function getOrderDate(): string
    {
        return $this->orderDate;
    }

    /**
     * @param string $orderDate
     */
    public function setOrderDate(string $orderDate)
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return float
     */
    public function getStartLatitude(): float
    {
        return $this->startLatitude;
    }

    /**
     * @param float $startLatitude
     */
    public function setStartLatitude(float $startLatitude)
    {
        $this->startLatitude = $startLatitude;
    }

    /**
     * @return float
     */
    public function getStartLongitude(): float
    {
        return $this->startLongitude;
    }

    /**
     * @param float $startLongitude
     */
    public function setStartLongitude(float $startLongitude)
    {
        $this->startLongitude = $startLongitude;
    }

    /**
     * @return float
     */
    public function getEndLatitude(): float
    {
        return $this->endLatitude;
    }

    /**
     * @param float $endLatitude
     */
    public function setEndLatitude(float $endLatitude)
    {
        $this->endLatitude = $endLatitude;
    }

    /**
     * @return float
     */
    public function getEndLongitude(): float
    {
        return $this->endLongitude;
    }

    /**
     * @param float $endLongitude
     */
    public function setEndLongitude(float $endLongitude)
    {
        $this->endLongitude = $endLongitude;
    }




}