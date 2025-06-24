CREATE OR REPLACE PROCEDURE connect_service(
    p_user_id INT,
    p_service_id INT,
    p_address VARCHAR(255)
LANGUAGE plpgsql
AS $$
BEGIN
    -- Проверка существования пользователя и услуги
    IF NOT EXISTS (SELECT 1 FROM users_app WHERE id_user = p_user_id) THEN
        RAISE EXCEPTION 'Пользователь с ID % не существует', p_user_id;
    END IF;
    
    IF NOT EXISTS (SELECT 1 FROM services WHERE id_services = p_service_id) THEN
        RAISE EXCEPTION 'Услуга с ID % не существует', p_service_id;
    END IF;
    
    -- Добавление записи
    INSERT INTO service_activation (
        id_services,
        id_user,
        date_connection,
        address_connection
    ) VALUES (
        p_service_id,
        p_user_id,
        CURRENT_DATE,
        p_address
    );
    
    COMMIT;
    RAISE NOTICE 'Услуга успешно подключена!';
END;
$$;
