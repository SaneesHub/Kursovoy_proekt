CREATE OR REPLACE FUNCTION check_user_service_quota()
RETURNS TRIGGER 
LANGUAGE plpgsql
AS $$
DECLARE
    active_services_count INTEGER;
    max_quota INTEGER := 10; -- Максимальное число услуг
BEGIN
    -- Считаем активные услуги пользователя
    SELECT COUNT(*) INTO active_services_count
    FROM service_activation
    WHERE id_user = NEW.id_user
    AND date_disconnection IS NULL;
    
    -- Если квота превышена
    IF active_services_count >= max_quota THEN
        RAISE EXCEPTION 'Пользователь ID % достиг лимита в % услуг', NEW.id_user, max_quota;
    END IF;
    RETURN NEW;
END;
$$;
-- Привязка триггера к таблице
CREATE TRIGGER before_service_activation_insert
BEFORE INSERT ON service_activation
FOR EACH ROW
EXECUTE FUNCTION check_user_service_quota();
