# **System Settings**
The `Setting` model is used to manage the configuration and customizable options of the application. These settings allow for flexible adjustments without modifying the source code. Each setting includes the following fields:

- **Title:** A unique name for the setting.
- **Description:** Explains the purpose of the setting (optional).
- **Value:** The default value assigned to the setting.
- **Validation:** Rules to validate the value during updates.

---

## 1. Cafe Name  
- **Purpose:** Stores the name of the cafe.  
- **Title:** `Cafe Name`  
- **Description:** The name of the cafe displayed throughout the system.  
- **Value:** Default value is `Cafe`.  
- **Validation:** `required|min:2|max:32`  

---

## 2. Image  
- **Purpose:** Represents an optional image for the cafe.  
- **Title:** `Image`  
- **Description:** An optional logo or banner image for the cafe.  
- **Value:** Default value is `0`.  
- **Validation:** `nullable|image`  

---

## 3. Color  
- **Purpose:** Sets the primary theme color for the application.  
- **Title:** `Color`  
- **Description:** Defines the visual appearance of the interface.  
- **Value:** Default value is `0`.  
- **Validation:** `required|color`  

---

## 4. Description  
- **Purpose:** A description of the cafe for promotional or informational purposes.  
- **Title:** `Description`  
- **Description:** A brief description about your cafe, required for marketing and branding.  
- **Value:** Default value is `0`.  
- **Validation:** `required|min:2|max:64`  

---

## 5. Password  
- **Purpose:** Adds a password for client-requested actions.  
- **Title:** `Password`  
- **Description:** A password used to authorize actions requested by clients.  
- **Value:** Default value is `1234`.  
- **Validation:** `required|min:2|max:32`  

---

## 6. Reset Time  
- **Purpose:** Specifies the reset time for daily sales accounting.  
- **Title:** `Reset Time`  
- **Description:** Time at which the sales data is reset for accounting purposes.  
- **Value:** Default value is `5:00`.  
- **Validation:** `required|time`  

---

## 7. Taxes  
- **Purpose:** Sets the tax percentage applicable to products and services.  
- **Title:** `Taxes`  
- **Description:** Percentage of taxes applied to sales and transactions.  
- **Value:** Default value is `5`.  
- **Validation:** `required|numeric|min:0|max:100`  

---

## 8. Services  
- **Purpose:** Defines the service fee percentage.  
- **Title:** `Services`  
- **Description:** Percentage charged as a service fee on transactions.  
- **Value:** Default value is `10`.  
- **Validation:** `required|numeric|min:0|max:100`  

---

## 9. Max Fixed Discount  
- **Purpose:** Specifies the highest fixed discount allowed.  
- **Title:** `Max Fixed Discount`  
- **Description:** The largest possible fixed discount value you can offer.  
- **Value:** Default value is `0`.  
- **Validation:** `required|numeric|min:0|max:2000000000`  

---

## 10. Max Rate Discount  
- **Purpose:** Sets the maximum percentage discount based on pricing rates.  
- **Title:** `Max Rate Discount`  
- **Description:** The highest discount percentage for price adjustments.  
- **Value:** Default value is `0`.  
- **Validation:** `required|numeric|min:0|max:100`  

---

## 11. Max Item Discount  
- **Purpose:** Determines the maximum discount applied to a single item.  
- **Title:** `Max Item Discount`  
- **Description:** The highest discount percentage or amount available per item.  
- **Value:** Default value is `0`.  
- **Validation:** `required|numeric|min:0|max:2000000000`  

---

### Notes  
- **Password Usage:**  
  The password can be included in any client-requested action to ensure proper authorization. This is useful for securing transactions and sensitive operations.

- **Default Values:**  
  Each setting has a predefined default value. Make sure to customize these as per your system’s specific requirements.

---

## **Model Functions**

### Setting Model (`Setting.php`)

```php
class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'value',
        'validation'
    ];

    // Retrieve the value for a specific setting by title
    public static function get($title)
    {
        return Setting::where('title', $title)->first()->value;
    }

    // Get the value for the 'Taxes' setting
    public static function getTaxes()
    {
        return Setting::where('title', 'Taxes')->first()->value;
    }

    // Get the value for the 'Services' setting
    public static function getServices()
    {
        return Setting::where('title', 'Services')->first()->value;
    }
}
```



# **Admin Settings**
## Subsection: *Item Settings*
This section includes models and relationships for managing menu items, categories, and subcategories. These models help in organizing the items into **Item Types**, **Categories**, and **Subcategories** with relevant images for menu display purposes.


---

## **1. ItemType**  
The **ItemType** model is designed to define the type of items, such as food, beverages, or desserts. Each item type can have an associated image that serves as a visual representation for the menu.

### **Model: `ItemType`**

```php
class ItemType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'title_ku',
        'image'
    ];

    /* Relation Functions */
}
```
Purpose
- Represents different types of items (e.g., food, beverages, desserts).
- Includes an image field that serves as a visual representation on the menu interface.
- Helps in categorizing items logically to improve the overall navigation and user experience.

---

## **2. ItemCategory**  
The **Category** model belongs to an ItemType and helps in organizing items within a specific type. It also has an associated image for menu display purposes.

### **Model: `ItemCategory`**

```php
class ItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_type_id',
        'title',
        'title_ar',
        'title_ku',
        'image'
    ];

    /* Relation Functions */
}
```

Purpose
- Acts as a sub-division within an Item Type (e.g., beverages may contain cold drinks, hot drinks).
- Includes an image that is displayed on the menu interface.

---

## **3. Subcategories**  
The **Subcategory** model belongs to a Category and is an optional level of classification. It’s not mandatory but is recommended when the client wants to display menus with three levels of navigation: **Type → Category → Subcategory**.

### **Model: `ItemSubcategory`**

```php
class ItemSubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_category_id',
        'title',
        'title_ar',
        'title_ku',
        'image'
    ];

    /* Relation Functions */
}
```

Purpose
- Provides a more detailed categorization of products.
- Optional but recommended for menus that include three levels of navigation (Type, Category, Subcategory).
- Includes an image that is displayed on the menu interface.

## Subsection: *Serving Settings*

This section handles critical delivery interactions ensuring timely delivery of orders while maintaining a seamless connection between delivery personnel, dining tables, and orders. It integrates multiple fields to manage the delivery process efficiently.


## **1. Table**  
The Table model represents the tables in a dining or delivery system, including seating capacity and notes for a restaurant or cafe environment. 

### **Model: `Table`**

```php 
class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'chairs',
        'note',
    ];

    // Automatically ensures a placeholder table exists for Takeaway interactions.
    public static function takeAway()
    {
        $table = Table::where('title', '#')->first();

        if (!$table) {
            $table = Table::create([
                'title' => '#',
                'chairs' => 0, 
                'note' => null,
            ]);
        }

        return $table;
    }

    // Counts active invoices for a table interaction
    public function activeInvoicesCount()
    {
        return $this->invoices->where('active', 1)->count();
    }
}
```

Purpose
- **`takeAway()`** function, Creates or fetches a table specifically designated for Takeaway interactions if no Takeaway identifier (#) already exists.
- The **`activeInvoicesCount()`** method returns the number of active invoices associated with a particular table.

## **2. Employee**  

The **`Employee`** model represents the employees who manage tables and serve customers in the system. This model ensures that employees are associated with specific invoices when required, supporting efficient tracking of service responsibilities.

### **Model: `Employee`**

```php

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];
}
```

Purpose
- **Employee Assignment**: When a table's invoice (dine-in) requires an employee, this model tracks the employee serving the table.
- **Active Employees**: Only active employees (**`active = true`**) can be assigned to serve tables, ensuring operational efficiency.
- This ensures proper assignment of staff and accountability for table service.

## **3. Payment Method**  

The **`PaymentMethod`** model represents the various payment methods available in the system, such as cash, credit card, or digital payments. This model helps manage and organize the types of payment options offered to customers.

### **Model: `PaymentMethod`**

```php
class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];
}
```

purpose
- The PaymentMethod model is used to list and manage the available payment methods in the system.
- This model is essential for managing payments from customers and recording transaction-related expenses, ensuring accurate and organized financial tracking.

## **4. Delivery Type**

The **`DeliveryType`** model represents the various methods by which orders are delivered to customers. This allows the system to handle multiple delivery services and manage their respective settings efficiently.

### **Model: `DeliveryType`**

```php 
class DeliverType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cash'
    ];
}
```

purpose
- This model ensures that the system can accommodate and differentiate between different delivery service providers.

### **Feature Work**
This model can be extended in the future to include additional attributes, such as:
- Commission Rates: To track and manage the commission for each delivery service.
- Delivery Charges: To specify service-specific delivery fees.

# **Item Settings**

The Item Settings section defines the configuration and attributes related to the products or menu items offered in the system. This section ensures that each item is well-structured, categorized, and dynamically managed based on its availability and ingredients. 

## **1. Item**

The **`Item`** model represents products or menu items offered in the system. It includes attributes to manage the item's details, availability, visibility, and associated categories or subcategories.

### **Model: `DeliveryType`**

```php

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'title_ku',
        'image',
        'is_available',
        'show',
        'show_ingredients',
        'item_type_id',
        'item_category_id',
        'item_subcategory_id',
        'note',
    ];

    public function available()
    {
        if(!$this->is_available)
        {
            return false;
        }

        foreach($this->itemIngredients->where('main', 1) as $itemIngredient)
        {
            if(!$itemIngredient->ingredient->is_available)
            {
                return false;
            }
        }

        return true;
    }

    public function validateIngredient()
    {
        foreach($this->prices as $price)
        {
            if (!$price->validateIngredient())
            {
                return false;
            }
        }

        return true;
    }
}
```
**Fields**

- **title, title_ar, title_ku**: Titles of the item in different languages for localization.
- **image**: An image of the item for display purposes.
- **is_available**: Indicates whether the item is currently available.
- **show**: Determines if the item is visible to users.
- **show_ingredients**: Specifies if the item's ingredients should be displayed to customers.
- **item_type_id, item_category_id, item_subcategory_id**: Relationships linking the item to its type, category, and optional subcategory.
- **note**: Additional information or notes about the item

**Key Methods**

1. **`available()`**:

    - Checks if the item is available for sale or display.
    - The item is considered unavailable if is_available is false or if any of its main ingredients (a related model) are unavailable.

2. **`validateIngredient()`**:
    - Ensures that all associated prices for the item have valid ingredients.
    - This method iterates through the related prices (a separate model) and calls validateIngredient() on each price instance.

**Ingredient Relationship**

Each item has a set of ingredients, managed through a relationship between Item and Ingredient models. This relationship is established in a pivot table (e.g., item_ingredient) with the following fields:

- **item_id**: References the associated item.
- **ingredient_id**: References the associated ingredient.


## **2. Ingredient**

The **`Ingredient`**  model represents the foundational elements used to create or assemble items in the system. It includes critical properties and functionality for managing the availability and inventory of ingredients.

### **Model: `Ingredient`**

```php 
class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'title_ku',
        'is_available',
        'inventory_unit_id',
        'quantity'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($ingredient) 
        {
            $ingredient->is_available = $ingredient->quantity > 0;
        });
    }

   /* Relation Function */
}
```

**Key Attributes**

- **Availability Status**: The **`is_available`** field dynamically updates based on the quantity. An ingredient is marked as available only if its quantity is greater than zero.
- **Inventory Unit**: Tracks the unit of measurement (e.g., **`grams`**, **`liters`**) through the inventory_unit_id field.
- **Quantity Management**: The **`quantity`** field maintains the stock level of the ingredient, ensuring accurate tracking and validation.


## **3. Price**

The  **`Price`**  model represents the pricing structure for items in the system, offering flexibility to define and manage multiple prices for an item, along with related ingredient details. This is particularly useful for scenarios such as offering multiple sizes or formats of a product, e.g., Regular and Large Pizza or Coffee in Grande, Tall, and Venti sizes.

### **Model: `Price`**

```php 
class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'title',
        'amount',
        'note',
    ];

    
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $itemIngredients = $model->item->itemIngredients;

            foreach ($itemIngredients as $key => $itemIngredient)
            {
                IngredientDetails::create([
                    'item_ingredients_id' => $itemIngredient->id,
                    'ingredient_id' => $itemIngredient->ingredient_id,
                    'price_id' => $model->id,
                    'amount' => 0,
                ]);
            }
        });
    }

    public static function activePrices()
    {
        $all_prices = Price::all();
        $prices = array();
        foreach ($all_prices as $key => $price) 
        {
            $prices[$price->id] = $price->item->title . ' (' . $price->title . ' ' . $price->amount . 'IQD)';
        }
        return $prices;
    }

    public function validateIngredient()
    {
        foreach ($this->ingredientDetails as $key => $ingredient) 
        {
            if($ingredient->amount == '0')
            {
                return 0;
            }
        }
        return true;
    }
}
```

**Key Attributes**
- **Item Association**: Each price entry is linked to an item_id, ensuring prices are specific to particular items.

- **Price Details**:
    - **`title`**: Describes the variation, such as "Regular" or "Large."
    - **`amount`**: Specifies the price for the variation.
    - **`note`**: Allows optional additional descriptions for the price tier.
    - 
**Dynamic Behavior**

- **Boot Method**: Automatically creates corresponding entries in the IngredientDetails table when a price is created:
- 
    - Retrieves all ingredients linked to the item.
    - Establishes records for each ingredient with a default `amount` of `0`.

**Utility Methods**

- **`activePrices()`**: 
    - Retrieves all prices in the system.
    - Formats each entry as `Item Title (Price Title Amount IQD)`, making it easy to understand for users.

- **`validateIngredient()`**:

    - Ensures all associated ingredient details have non-zero amounts.
    - Returns `0` if any ingredient amount is `0`, otherwise returns `true`.

## **4. ItemIngredient**

The **`ItemIngredient`** model serves as the intermediary linking items to their ingredients, enabling a clear relationship and efficient management of the components required for each item.

### **Model: `ItemIngredient`**

```php
class ItemIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'ingredient_id',
        'main',
        'note',
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $prices = $model->item->prices;

            foreach ($prices as $key => $price) 
            {
                IngredientDetails::create([
                    'item_ingredients_id' => $model->id,
                    'ingredient_id' => $model->ingredient_id,
                    'price_id' => $price->id,
                    'amount' => 0,
                ]);
            }
        });
    }
}
```

#### **Key Attributes**  
- **`item_id`:** Associates the ingredient with a specific item.  
- **`ingredient_id`:** Identifies the ingredient used in the item.  
- **`main`:** A flag to indicate whether the ingredient is a primary (or required) component of the item.  
- **`note`:** Optional details about the ingredient’s role in the item.  

#### **Dynamic Behavior**  
- **Boot Method:**  
  Upon creating a new **ItemIngredient** record, the system automatically:  
  - Retrieves all prices associated with the linked item.  
  - Creates a corresponding entry in the **IngredientDetails** table for each price, initializing the `amount` to `0`.  

#### **Purpose**  

- Each item can define its unique set of ingredients.  
- Any new ingredient linked to an item will immediately reflect across all price variations of that item, keeping ingredient details up-to-date.  


## **5. IngredientDetails**

The **IngredientDetails** model connects ingredients to their prices and quantities, maintaining detailed relationships between items, prices, and their components.  

### **Model: `IngredientDetails`**

```php
class IngredientDetails extends Model
{
    use HasFactory;
    // Specify the table name if it does not follow the Laravel convention
    protected $table = 'ingredient_details';

    // Specify the fillable attributes
    protected $fillable = [
        'item_ingredients_id',
        'ingredient_id',
        'price_id',
        'amount',
    ];

    public function consume()
    {
        if($this->ingredient->inventories->isEmpty())
        {
            return;
        }

        $ingredient = $this->ingredient;

        $ingredient->quantity = max(0, $ingredient->quantity - $this->amount);
        $ingredient->save();
    }

    public function restock()
    {
        $ingredient = $this->ingredient;

        $ingredient->quantity += $this->amount;
        $ingredient->save();
    }
}
```


### **Key Attributes**  
- **`item_ingredients_id`**: Links the specific ingredient to an item.  
- **`ingredient_id`**: Identifies the individual ingredient.  
- **`price_id`**: Associates the ingredient with a specific price variation.  
- **`amount`**: Represents the quantity of the ingredient required per price or item variation.  


### **Methods**  

1. **`consume()`**  
- **Purpose:** Deducts the consumed quantity of the ingredient when an order is processed.  
- If the linked ingredient has no available inventory, the method exits without action.  
- Updates the `quantity` field in the ingredient model to reflect the consumption of stock.

2. **`restock()`**  
- **Purpose:** Restores the ingredient quantity back to inventory when an order is canceled or deleted.  
- This scenario is particularly useful if an order was mistakenly placed by an employee but hasn't been processed fully.
- It ensures the system restores ingredient quantities correctly, maintaining inventory accuracy.

---

### **Business Context**  
- **Recipe Management:** Acts as a central component in recipe tracking by detailing how ingredients are tied to item prices and variations.  
- **Inventory Accuracy:** The `consume()` and `restock()` methods guarantee that ingredient stock remains accurate during both sales transactions and order cancellations.  
- **Error Handling:** In case of order mistakes, **`restock()`** ensures that ingredient quantities remain intact and up-to-date, preserving operational integrity and preventing stock discrepancies.  

