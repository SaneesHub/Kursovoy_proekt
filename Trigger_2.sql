CREATE OR REPLACE FUNCTION generate_invoice_on_activation()
RETURNS TRIGGER 
LANGUAGE plpgsql
AS $$
BEGIN
    -- Вставляем запись в таблицу счетов
    INSERT INTO invoices (
        id_services,
        id_user,
        id_connection,
        sum_payment,
        date_formation,
        status_payment
    ) VALUES (
        NEW.id_services,
        NEW.id_user,
        NEW.id_connection,
        (SELECT tariff_price FROM services WHERE id_services = NEW.id_services),
        CURRENT_DATE,
        FALSE -- Статус "Не оплачено"
    );
    RETURN NEW;
END;
$$;
-- Привязка триггера
CREATE TRIGGER after_service_activation_insert
AFTER INSERT ON service_activation
FOR EACH ROW
EXECUTE FUNCTION generate_invoice_on_activation();
