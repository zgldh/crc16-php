<?php

    public function testPerformance()
    {
        $longString = str_repeat("a", 100000);
        $startTime = microtime(true);
        Crc16::MODBUS($longString);
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        // Assert that the execution time is within an acceptable range (e.g., less than 0.1 seconds)
        // This value might need adjustment based on the environment.
        $this->assertLessThan(0.1, $executionTime, "Performance test failed: Execution time too long.");
    }

