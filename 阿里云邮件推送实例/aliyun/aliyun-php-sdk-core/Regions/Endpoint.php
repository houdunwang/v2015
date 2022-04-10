<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
class Endpoint
{
    private $name;
    private $regionIds;
    private $productDomains;
    
    public function __construct($name, $regionIds, $productDomains)
    {
        $this->name = $name;
        $this->regionIds = $regionIds;
        $this->productDomains = $productDomains;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getRegionIds()
    {
        return $this->regionIds;
    }
    
    public function setRegionIds($regionIds)
    {
        $this->regionIds = $regionIds;
    }
    
    public function getProductDomains()
    {
        return $this->productDomains;
    }
    
    public function setProductDomains($productDomains)
    {
        $this->productDomains = $productDomains;
    }
}
