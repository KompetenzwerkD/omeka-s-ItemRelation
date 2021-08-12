CREATE TABLE sub_item (id INT AUTO_INCREMENT NOT NULL, parent_resource_template_id INT DEFAULT NULL, child_resource_template_id INT DEFAULT NULL, connecting_property_id INT DEFAULT NULL, label_property_id INT DEFAULT NULL, code_property_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, `label` VARCHAR(190) NOT NULL, code_template VARCHAR(190) DEFAULT NULL, UNIQUE INDEX UNIQ_388DBADFEA750E8 (`label`), INDEX IDX_388DBADFA5726818 (parent_resource_template_id), INDEX IDX_388DBADF5E8030D1 (child_resource_template_id), INDEX IDX_388DBADF6CD8148E (connecting_property_id), INDEX IDX_388DBADFBF4EC31A (label_property_id), INDEX IDX_388DBADF1DD3FA5C (code_property_id), INDEX IDX_388DBADF7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
ALTER TABLE sub_item ADD CONSTRAINT FK_388DBADFA5726818 FOREIGN KEY (parent_resource_template_id) REFERENCES resource_template (id) ON DELETE SET NULL;
ALTER TABLE sub_item ADD CONSTRAINT FK_388DBADF5E8030D1 FOREIGN KEY (child_resource_template_id) REFERENCES resource_template (id) ON DELETE SET NULL;
ALTER TABLE sub_item ADD CONSTRAINT FK_388DBADF6CD8148E FOREIGN KEY (connecting_property_id) REFERENCES property (id) ON DELETE SET NULL;
ALTER TABLE sub_item ADD CONSTRAINT FK_388DBADFBF4EC31A FOREIGN KEY (label_property_id) REFERENCES property (id) ON DELETE SET NULL;
ALTER TABLE sub_item ADD CONSTRAINT FK_388DBADF1DD3FA5C FOREIGN KEY (code_property_id) REFERENCES property (id) ON DELETE SET NULL;
ALTER TABLE sub_item ADD CONSTRAINT FK_388DBADF7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE SET NULL;