<?php
class WeatherData
{
    protected $data;
    
    public static function get(DateTime $from, DateTime $until = null)
    {
        
        $from  = $from->modify('today 0:00:00');
        $until = $until ?: $from->clone();
        $until->modify('today 23:59:59');

        return new self($from, $until);
    }
    
    public function __construct(DateTime $from, DateTime $until)
    {
        $query = "SELECT *
                  FROM `weather_data`
                  WHERE `timestamp` BETWEEN :from AND :until
                  ORDER BY `timestamp` ASC";
        $statement = DB::get()->prepare($query);
        $statement->bindValue(':from', $from->getTimestamp());
        $statement->bindValue(':until', $until->getTimestamp());
        $statement->execute();
        $temp = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $last = null;
        foreach ($temp as $index => $row) {
            $row['delta'] = $last ? $row['precipitation'] - $last['precipitation'] : 0;
            $temp[$index] = $row;
            
            $last = $row;
        }
        $this->data = $temp;
    }
    
    public function toJSON($column = null)
    {
        $result = $this->data;
        if ($column !== null) {
            foreach ($result as $index => $row) {
                $result[$index] = array(
                    $row['timestamp'],
                    $row[$column]
                );
            }
        }
        return json_encode($result);
    }
}